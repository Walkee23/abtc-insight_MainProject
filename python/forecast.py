#!/usr/bin/env python3
"""
ABTC-Insight forecasting engine.

Holt-Winters exponential smoothing (statsmodels) on the daily patient registrations.
The Laravel page (app/Http/Controllers/ForecastingController.php) sends the training window as JSON
on stdin and reads one JSON object from stdout:

    in : {"y": [daily counts...], "start": "YYYY-MM-DD", "alpha": 0.3, "beta": 0.1, "gamma": 0.1,
          "phi": 0.95, "season": 7, "horizon": 14}
    out: {"ok": true, "method": "...", "seasonal": true, "values": [h1, h2, ...], "sigma": ..., "mape": ...,
          "level": ..., "trend": ..., "engine": "Python 3.13.2 / statsmodels 0.14.6 / pandas 3.0.1"}
         or {"ok": false, "error": "..."}

Model
  * additive trend (damped by phi) + additive weekly season when there are at least two full weeks of
    data; otherwise Holt's linear trend only
  * alpha (level), beta (trend) and gamma (season) are the values of the page's sliders and are used as
    given - they are not re-optimised
  * start values come from every complete week of the window, so a single odd week does not set the
    weekday pattern
  * sigma is the root-mean-square one-step error and mape the weighted absolute percentage error
    (total miss / total actual), both measured after the first week, which only settles the start values
"""
import json
import platform
import sys
import warnings

import numpy as np
import pandas as pd
import statsmodels
from statsmodels.tsa.holtwinters import ExponentialSmoothing

warnings.simplefilter("ignore")


def start_values(y: np.ndarray, m: int, seasonal: bool):
    """Level, trend and (when seasonal) the m weekday indexes the recursion starts from."""
    if not seasonal:
        return float(y[0]), float(y[1] - y[0]), None

    seasons = len(y) // m
    means = [float(y[k * m:(k + 1) * m].mean()) for k in range(seasons)]
    level = means[0]
    trend = (means[-1] - means[0]) / ((seasons - 1) * m)
    season = np.array([np.mean([y[k * m + i] - means[k] for k in range(seasons)]) for i in range(m)])
    return level, trend, season


def run(req: dict) -> dict:
    y = np.asarray(req["y"], dtype=float)
    n = len(y)
    m = int(req.get("season", 7))
    horizon = int(req["horizon"])
    alpha, beta, gamma = float(req["alpha"]), float(req["beta"]), float(req["gamma"])
    phi = float(req.get("phi", 0.95))

    if n < 3:
        return {"ok": False, "error": "At least 3 days of data are needed."}
    if horizon < 1 or horizon > 400:
        return {"ok": False, "error": "Horizon out of range."}
    if not np.isfinite(y).all():
        return {"ok": False, "error": "The series contains values that are not numbers."}

    seasonal = n >= 2 * m
    index = pd.date_range(req["start"], periods=n, freq="D") if req.get("start") else pd.RangeIndex(n)
    series = pd.Series(y, index=index)

    level, trend, season = start_values(y, m, seasonal)
    model = ExponentialSmoothing(
        series,
        trend="add",
        damped_trend=True,
        seasonal="add" if seasonal else None,
        seasonal_periods=m if seasonal else None,
        initialization_method="known",
        initial_level=level,
        initial_trend=trend,
        initial_seasonal=season,
    )
    fit = model.fit(
        smoothing_level=alpha,
        smoothing_trend=beta,
        smoothing_seasonal=gamma if seasonal else None,
        damping_trend=phi,
        optimized=False,
    )

    forecast = np.maximum(0.0, np.asarray(fit.forecast(horizon), dtype=float))

    # one-step errors; the first week (or day) only settles the start values
    skip = m if seasonal else 1
    errors = (series - fit.fittedvalues).to_numpy()[skip:]
    actual = y[skip:]
    sigma = float(np.sqrt(np.mean(errors ** 2))) if len(errors) > 1 else 0.0
    mape = float(np.abs(errors).sum() / actual.sum() * 100) if actual.sum() > 0 else None

    return {
        "ok": True,
        "method": "Holt-Winters (additive)" if seasonal else "Holt Linear Trend",
        "seasonal": seasonal,
        "values": [round(float(v), 4) for v in forecast],
        "sigma": round(sigma, 4),
        "mape": None if mape is None else round(mape, 4),
        "level": round(float(fit.level.iloc[-1]), 4),
        "trend": round(float(fit.trend.iloc[-1]), 4),
        "engine": f"Python {platform.python_version()} / statsmodels {statsmodels.__version__} / pandas {pd.__version__}",
    }


def main() -> int:
    try:
        result = run(json.load(sys.stdin))
    except Exception as exc:  # report anything unexpected as JSON so the page can fall back
        result = {"ok": False, "error": f"{type(exc).__name__}: {exc}"}
    sys.stdout.write(json.dumps(result))
    return 0 if result.get("ok") else 1


if __name__ == "__main__":
    sys.exit(main())
