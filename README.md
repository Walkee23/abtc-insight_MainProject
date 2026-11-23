<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## ABTC-Insight: Forecasting (Python) setup

The Admin **Forecasting** page runs its numbers in Python (`python/forecast.py`, Holt-Winters from `statsmodels`).
The code comes with the repository, but **Python and its packages are installed on each computer**, so every
developer does this once after pulling.

1. Install **Python 3.9 or newer** from python.org and tick **"Add Python to PATH"** in the installer.
2. From the project folder, install the packages:

   ```
   python -m pip install -r python\requirements.txt
   ```

3. Check that it works. The result should be one line starting with `{"ok": true`.

   Command Prompt (`cmd`):

   ```
   python python\forecast.py < python\sample_input.json
   ```

   PowerShell:

   ```powershell
   Get-Content python/sample_input.json | python python/forecast.py
   ```

   (`Get-Content` only exists in PowerShell; in Command Prompt use the `<` form. `python/sample_input.json` is
   part of the repository, so pull the latest branch first if the file is missing.)

4. **If the site runs under XAMPP / Apache**, Apache usually does not see your PATH. Put the full path of
   your Python in your own `.env` (the `.env` file is not committed, so each developer sets it) and clear the
   config cache:

   ```
   PYTHON_BIN=C:\Users\<your-name>\AppData\Local\Programs\Python\Python313\python.exe
   ```

   ```
   php artisan config:clear
   ```

   `where python` shows the path to use. With `php artisan serve` this is usually not needed.

### How to tell whether Python is being used

- On the Forecasting page, an amber line **"PHP built-in fallback (Python was not available)"** means the page is
  using the PHP copy of the model instead of Python. The page still works, but it is not the Python result.
  The notice ends with the reason, for example `python.exe: exit code 1, The system cannot find the path specified.`
  or `ModuleNotFoundError: No module named 'statsmodels'`.
- The full reason is also written to `storage/logs/laravel.log` as `Forecasting: the Python engine could not be used...`.
- Common causes: Python not installed or not on PATH, the Windows Store `python` shortcut opening instead of real
  Python, packages not installed (`ModuleNotFoundError`), or `PYTHON_BIN` not set under Apache.
- A failed run is not remembered, so once Python works the next page load uses it.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
"# abtc-insight_MainProject" 
