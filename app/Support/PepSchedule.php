<?php

namespace App\Support;

/**
 * The PEP dose schedule of a case, from its Section VII dose type and route:
 *
 *   Primary, IM route (intramuscular)  -> Day 0, 3, 7, 14
 *   Primary, ID route (intradermal)    -> Day 0, 3, 7, 28
 *   Booster                            -> Day 0, 3
 *
 * A case with no route on record (imported records, or a draft) is treated like ID: Day 28.
 * Every screen and report that needs "which doses does this case have" goes through here.
 */
class PepSchedule
{
    /** The day numbers of the course, Day 0 first. */
    public static function days(?string $doseType, ?string $route): array
    {
        if ($doseType === 'Booster') {
            return [0, 3];
        }

        return $route === 'IM' ? [0, 3, 7, 14] : [0, 3, 7, 28];
    }

    /** The day numbers after Day 0 (the visits a returning patient can check in for). */
    public static function followUpDays(?string $doseType, ?string $route): array
    {
        return array_values(array_diff(self::days($doseType, $route), [0]));
    }

    /**
     * SQL (MySQL) that is true when every dose of the course has a recorded date.
     * $s7 is the alias of bite_section7_immunization in the query.
     */
    public static function completeSql(string $s7 = 's7'): string
    {
        return "CASE WHEN {$s7}.dose_type = 'Booster' THEN {$s7}.day3_date IS NOT NULL
                     WHEN {$s7}.route = 'IM' THEN ({$s7}.day3_date IS NOT NULL AND {$s7}.day7_date IS NOT NULL AND {$s7}.day14_date IS NOT NULL)
                     ELSE ({$s7}.day3_date IS NOT NULL AND {$s7}.day7_date IS NOT NULL AND {$s7}.day28_date IS NOT NULL) END";
    }
}
