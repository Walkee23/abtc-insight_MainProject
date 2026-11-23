<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Imports historical animal bite cases from an Excel (.xlsx) or .csv sheet.
 *
 * Every sheet row becomes one complete case, written exactly the way the Staff/Clinical flow would
 * have written it, so all the analytics, forecasting and map pages pick it up:
 *
 *   inflow_general_particulars  (status = Encoded, queue id "H<n>" so it never mixes with N/P queues)
 *   patients                    (one per person; a repeat bite of the same name + birthdate becomes case #2, #3 ...)
 *   bite_cases                  (+ category, outcome)
 *   bite_section3_exposure      (animal, bite date, circumstances)
 *   bite_section6_wound_description
 *   bite_section7_immunization  (dose dates, vaccine brand, passive immunization)
 *   bite_section8_remarks       (only when the sheet has remarks)
 *
 * Columns are found by their header text (not position) - see HEADERS. Rows that were imported before
 * (same name + birthdate + bite date) are skipped, so the same file can safely be imported twice.
 */
class BiteCaseImporter
{
    /** Header aliases per field. Headers are compared upper-cased with everything except A-Z/0-9 removed. */
    private const HEADERS = [
        'name'      => ['NAMEOFPATIENT', 'PATIENTNAME', 'NAME', 'FULLNAME', 'PATIENT'],
        'age'       => ['AGE'],
        'sex'       => ['GENDER', 'SEX'],
        'dob'       => ['BIRTHDATE', 'DATEOFBIRTH', 'DOB', 'BIRTHDAY'],
        'barangay'  => ['BARANGAY', 'BRGY', 'BRGYNAME'],
        'animal'    => ['BITINGANIMAL', 'BITTINGANIMAL', 'ANIMAL', 'ANIMALTYPE', 'TYPEOFANIMAL'],
        'category'  => ['CATEGORY', 'CATEGORYOFEXPOSURE', 'CAT'],
        'd1'        => ['1STDOSE', 'FIRSTDOSE', 'DOSE1', 'DAY0'],
        'd2'        => ['2NDDOSE', 'SECONDDOSE', 'DOSE2', 'DAY3'],
        'd3'        => ['3RDDOSE', 'THIRDDOSE', 'DOSE3', 'DAY7'],
        // the 4th dose of a 4-dose primary course is the Day 28 dose (Day 14 is not part of the schedule)
        'd28'       => ['DAY28', '4THDOSE', 'DOSE4', '5THDOSE', 'DOSE5'],
        'vaccine'   => ['VACCINE', 'VACCINEBRAND', 'BRAND', 'VACCINEUSED'],
        'booster'   => ['BOOSTER'],
        'erig'      => ['ERIG'],
        'hrig'      => ['HRIG'],
        'stray'     => ['STRAY'],
        'remarks'   => ['REMARKS', 'REMARK', 'NOTES'],
        'outcome'   => ['TREATMENTOUTCOME', 'OUTCOME'],
        'wound'     => ['TYPEOFWOUND', 'WOUNDTYPE', 'WOUND', 'TYPEOFBITE'],
        'site'      => ['SITEOFBITE', 'BITESITE', 'SITE'],
        'bitedate'  => ['DATEANDTIMEOFBITE', 'DATEOFBITE', 'BITEDATE', 'DATEOFINCIDENT', 'DATEOFEXPOSURE',
                        'DATEANDTIMEOFBITTINGINCIDENT', 'DATEANDTIMEOFBITINGINCIDENT', 'DATEOFBITTINGINCIDENT', 'DATEOFBITINGINCIDENT'],
        'animalvax' => ['VACCINATIONSTATUSOFBITTINGANIMAL', 'VACCINATIONSTATUSOFBITINGANIMAL', 'ANIMALVACCINATIONSTATUS', 'ANIMALVAXSTATUS'],
        'circ'      => ['CIRCUMSTANCESOFBITE', 'CIRCUMSTANCES', 'CIRCUMSTANCE', 'PROVOKED', 'PROVOKEDUNPROVOKED'],
        'contact'   => ['CONTACTNUMBER', 'CONTACTNO', 'CONTACT', 'MOBILE', 'MOBILENUMBER', 'PHONE'],
    ];

    /** Fields a sheet must have a column for. The bite date may be replaced by the 1st dose date. */
    private const REQUIRED = ['name' => 'name of patient', 'dob' => 'birthdate', 'barangay' => 'barangay'];

    /** The sheet's treatment outcome codes: 0 = all 3 doses, 1 / 2 = course not finished (checked against the dose columns). */
    private const OUTCOME_CODES = ['0' => 'Completed', '1' => 'Incomplete', '2' => 'Incomplete'];

    private const VACCINES = [
        'VAXIRAB' => 'VAXIRAB (PCEC)', 'SPEEDA' => 'SPEEDA (PVRV)', 'VERORAB' => 'VERORAB (PVRV)',
    ];

    /** Spellings used in the sheets that differ from config/barangays.php (normalised key => official name). */
    private const BARANGAY_ALIASES = [
        'SAMBAG1' => 'Sambag I', 'SAMBAG2' => 'Sambag II', 'SUDLON1' => 'Sudlon I', 'SUDLON2' => 'Sudlon II',
        'POBPARDO' => 'Pardo', 'POBLACIONPARDO' => 'Pardo', 'PARDOPOBLACION' => 'Pardo',
        'PUNGOLSIBUGAY' => 'Pung-ol', 'PUNGOL' => 'Pung-ol', 'PAHINASANNICOLAS' => 'San Nicolas Pahina',
        'CAPITOLSITE' => 'Capitol', 'DULJOFATIMA' => 'Duljo', 'BUOT' => 'Bout-Taup', 'BUOTTAUP' => 'Bout-Taup',
        'STACRUZ' => 'Sta. Cruz', 'SANTACRUZ' => 'Sta. Cruz', 'STONINO' => 'Sto. Niño', 'SANTONINO' => 'Sto. Niño',
        'KINASANGAN' => 'Kinasang-an', 'TPADILLA' => 'T.Padilla', 'BOLUZ' => 'Bo.Luz', 'TAPTAP' => 'TapTap',
    ];

    private bool $dryRun;

    private ?int $yearHint = null;

    /** @var array<string,string> normalised barangay => official spelling */
    private array $barangays = [];

    /** @var array<string,true> dedupe keys of everything already in the database / this run */
    private array $seen = [];
    /** @var array<string,string> "name|dob" => patient_id */
    private array $patients = [];
    /** @var array<string,int> patient_id => highest case_number */
    private array $caseNo = [];
    /** @var array<string,int> queue date => last H-number used */
    private array $queueSeq = [];
    /** @var array<string,int> "CEB-reg-dob" => patients using that prefix */
    private array $patientSeq = [];

    /** @var array<int, array<string, mixed>> */
    private array $bufSec3 = [];
    /** @var array<int, array<string, mixed>> */
    private array $bufSec6 = [];
    /** @var array<int, array<string, mixed>> */
    private array $bufSec7 = [];
    /** @var array<int, array<string, mixed>> */
    private array $bufSec8 = [];

    public function __construct(bool $dryRun = false)
    {
        $this->dryRun = $dryRun;
        foreach (array_keys((array) config('barangays')) as $b) {
            $this->barangays[$this->norm($b)] = $b;
        }
    }

    /** Largest sheet accepted, in bytes (it is uploaded in pieces, so this is not tied to php.ini's upload limits). */
    public const MAX_FILE_BYTES = 100 * 1048576;

    /**
     * Size of one upload piece: half of what a single request may carry (the smaller of upload_max_filesize and
     * post_max_size, default 2 MB), between 128 KB and 1 MB, so a piece always fits however strict php.ini is.
     */
    public static function chunkBytes(): int
    {
        $toBytes = function (string $v): int {
            $v = trim($v);
            $n = (int) $v;
            return match (strtolower(substr($v, -1))) {
                'g' => $n * 1073741824,
                'm' => $n * 1048576,
                'k' => $n * 1024,
                default => $n,
            };
        };
        $limits = array_filter([$toBytes((string) ini_get('upload_max_filesize')), $toBytes((string) ini_get('post_max_size'))]);
        $limit = $limits ? min($limits) : 2 * 1048576;
        return max(131072, min(1048576, (int) floor($limit / 2)));
    }

    /** Official sheet headers, for the downloadable template. */
    public static function templateHeaders(): array
    {
        return ['NAME OF PATIENT', 'AGE', 'GENDER', 'BIRTHDATE', 'BARANGAY', 'BITING ANIMAL', 'CATEGORY', '1ST DOSE', '2ND DOSE', '3RD DOSE',
            'VACCINE', 'BOOSTER', 'ERIG', 'HRIG', 'STRAY', 'REMARKS', 'TREATMENT OUTCOME', 'TYPE OF WOUND', 'SITE OF BITE',
            'DATE AND TIME OF BITE', 'VACCINATION STATUS OF BITING ANIMAL', 'CIRCUMSTANCES OF BITE', 'CONTACT NUMBER'];
    }

    /** One fictional example row for the template. */
    public static function templateExample(): array
    {
        return ['DELA CRUZ, JUAN A.', '25', 'M', '2000-03-15', 'LAHUG', 'D', 'II', '2025-01-10', '2025-01-13', '2025-01-17',
            'VAXIRAB', '', '', '', 'S', '', '0', 'S-AB', 'L FOREARM', '1/9/2025 2:30PM', 'U', 'P', '09171234567'];
    }

    // ------------------------------------------------------------------ main entry

    /**
     * @return array{total:int, imported:int, duplicates:int, failed:int, new_patients:int, repeat_patients:int,
     *               date_from:?string, date_to:?string, errors:array<int,array{row:int,message:string}>,
     *               warnings:array<int,string>, dry_run:bool}
     */
    public function import(XlsxReader $reader): array
    {
        @set_time_limit(0);
        @ini_set('memory_limit', '768M');

        $stats = ['total' => 0, 'imported' => 0, 'duplicates' => 0, 'failed' => 0, 'new_patients' => 0, 'repeat_patients' => 0,
            'date_from' => null, 'date_to' => null, 'errors' => [], 'warnings' => [], 'sheets' => [], 'skipped_sheets' => [],
            'dry_run' => $this->dryRun];
        $unknownBarangays = [];
        $multi = count($reader->sheetNames()) > 1;
        $sheetProblem = null;

        DB::beginTransaction();
        try {
            $this->preload();

            // every tab of the workbook is read; tabs that are not bite case lists (summaries, reports,
            // pre-exposure lists...) are recognised by their columns and skipped
            foreach ($reader->sheetNames() as $sheetIndex => $sheetName) {
                $map = null;
                $mark = $stats;
                $tabMonth = $this->yearHint ? $this->monthOfTab($sheetName) : null;

                foreach ($reader->rows($sheetIndex) as $rowNo => $cells) {
                    if ($map === null) {
                        // the header is the first row that names the required columns (title rows above it are ignored)
                        $candidate = $this->mapHeaders($cells);
                        if ($candidate && !array_diff_key(self::REQUIRED, $candidate)) {
                            if (!isset($candidate['animal']) && !isset($candidate['bitedate']) && !isset($candidate['category'])) {
                                break; // names and birthdates, but no bite information: not a bite case list
                            }
                            if (!isset($candidate['bitedate']) && !isset($candidate['d1'])) {
                                $sheetProblem ??= 'The sheet needs a "DATE AND TIME OF BITE" column (or a "1ST DOSE" column to use instead).';
                                break;
                            }
                            $map = $candidate;
                        } elseif ($rowNo > 15) {
                            break;
                        }
                        continue;
                    }

                    $stats['total']++;
                    try {
                        $row = $this->parseRow($cells, $map, $unknownBarangays);
                        $key = $row['dedupe'];
                        if (isset($this->seen[$key])) {
                            $stats['duplicates']++;
                            continue;
                        }

                        if ($tabMonth) {
                            // a month tab (with a known year) holds bites from about that month; anything much further
                            // away is almost always a typo in the year, and would distort the monthly analytics
                            $day = substr($row['bite_at'], 0, 10);
                            $first = Carbon::create($this->yearHint, $tabMonth, 1);
                            if ($day < $first->copy()->subMonths(6)->toDateString() || $day > $first->copy()->addMonth()->endOfMonth()->toDateString()) {
                                throw new InvalidArgumentException("Date of bite ({$day}) is far from the {$sheetName} tab - please check the year.");
                            }
                        }

                        if ($this->dryRun) {
                            $personKey = mb_strtolower($row['name']) . '|' . $row['dob'];
                            $isNewPatient = !isset($this->patients[$personKey]);
                            $this->patients[$personKey] ??= 'dry-run';
                        } else {
                            $isNewPatient = $this->store($row);
                        }

                        $this->seen[$key] = true;
                        $stats['imported']++;
                        $isNewPatient ? $stats['new_patients']++ : $stats['repeat_patients']++;
                        $day = substr($row['bite_at'], 0, 10);
                        if ($stats['date_from'] === null || $day < $stats['date_from']) { $stats['date_from'] = $day; }
                        if ($stats['date_to'] === null || $day > $stats['date_to']) { $stats['date_to'] = $day; }
                    } catch (InvalidArgumentException $e) {
                        $stats['failed']++;
                        $this->addError($stats, $rowNo, $e->getMessage(), $multi ? $sheetName : null);
                    } catch (\Throwable $e) {
                        $stats['failed']++;
                        $this->addError($stats, $rowNo, 'Could not be saved (' . class_basename($e) . ').', $multi ? $sheetName : null);
                        report($e);
                    }
                }

                if ($map === null) {
                    $stats['skipped_sheets'][] = $sheetName;
                    continue;
                }
                $stats['sheets'][] = [
                    'name'       => $sheetName,
                    'total'      => $stats['total'] - $mark['total'],
                    'imported'   => $stats['imported'] - $mark['imported'],
                    'duplicates' => $stats['duplicates'] - $mark['duplicates'],
                    'failed'     => $stats['failed'] - $mark['failed'],
                ];
            }

            if (!$stats['sheets']) {
                throw $sheetProblem ? new InvalidArgumentException($sheetProblem) : $this->missingColumns([]);
            }

            if (!$this->dryRun) {
                $this->flushBuffers();
            }

            $this->dryRun ? DB::rollBack() : DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        foreach ($unknownBarangays as $name => $n) {
            if ($name === 'outside') {
                $stats['warnings'][] = "{$n} " . ($n === 1 ? 'row is' : 'rows are') . ' from outside Cebu City ("Others (...)") - saved as written, and not shown on the spatial map.';
                continue;
            }
            $stats['warnings'][] = "Barangay \"{$name}\" is not in the official barangay list ({$n} " . ($n === 1 ? 'row' : 'rows') . ') - saved as written, but it will not show on the spatial map.';
        }
        if ($stats['total'] === 0) {
            $stats['warnings'][] = 'The sheet has a header row but no data rows under it.';
        }
        if ($stats['skipped_sheets']) {
            $n = count($stats['skipped_sheets']);
            $stats['warnings'][] = $n . ($n === 1 ? ' sheet was' : ' sheets were') . ' skipped because ' . ($n === 1 ? 'it is' : 'they are')
                . ' not an animal bite case list: ' . implode(', ', $stats['skipped_sheets']) . '.';
        }

        return $stats;
    }

    private function addError(array &$stats, int $row, string $message, ?string $sheet = null): void
    {
        $stats['errors'][] = ['row' => $row, 'message' => $message] + ($sheet !== null ? ['sheet' => $sheet] : []);
    }

    // ------------------------------------------------------------------ headers

    /** @return array<string,int>|null field => column index */
    private function mapHeaders(array $cells): ?array
    {
        $map = [];
        $prev = '';
        foreach ($cells as $i => $text) {
            $h = $this->norm($text);
            if ($h === '' && $prev === '3RDDOSE') {
                // the DOH sheet has an untitled column right after the 3rd dose: it holds the vaccine brand
                $map['vaccine'] ??= $i;
            }
            $prev = $h !== '' ? $h : $prev;
            if ($h === '') {
                continue;
            }
            foreach (self::HEADERS as $field => $aliases) {
                if (isset($map[$field])) {
                    continue;
                }
                if (in_array($h, $aliases, true)) {
                    $map[$field] = $i;
                    continue 2;
                }
            }
            // tolerate small wording differences of the long header
            if (!isset($map['animalvax']) && str_contains($h, 'VACCINATION') && str_contains($h, 'ANIMAL')) {
                $map['animalvax'] = $i;
            }
        }
        return $map ?: null;
    }

    private function missingColumns(array $found): InvalidArgumentException
    {
        $missing = array_values(array_diff_key(self::REQUIRED, $found));
        return new InvalidArgumentException(
            'The header row could not be found. The first rows of the sheet must contain these columns: ' . implode(', ', self::REQUIRED)
            . '. Use "Download template" for the expected layout.'
        );
    }

    private function norm(?string $s): string
    {
        return preg_replace('/[^A-Z0-9]/', '', strtoupper((string) $s));
    }

    // ------------------------------------------------------------------ one row

    private function parseRow(array $c, array $map, array &$unknownBarangays): array
    {
        $get = fn (string $f) => isset($map[$f]) ? trim((string) ($c[$map[$f]] ?? '')) : '';

        // --- identity
        $name = $this->cleanName($get('name'));
        if ($name === '') {
            throw new InvalidArgumentException('Missing patient name.');
        }
        $dob = $this->date($get('dob'))['date'] ?? null;
        if (!$dob) {
            throw new InvalidArgumentException('Missing or unreadable birthdate.');
        }
        if ($dob > date('Y-m-d')) {
            throw new InvalidArgumentException('Birthdate is in the future.');
        }

        // --- dates
        $d1 = $this->date($get('d1'), $this->yearHint)['date'] ?? null;
        // a bite date written without a year ("10/5, 3PM") takes the year of the 1st dose, else the year of the file
        $bite = $this->date($get('bitedate'), $d1 ? (int) substr($d1, 0, 4) : $this->yearHint);
        if (!empty($bite['guessed']) && $d1 && $bite['date'] > Carbon::parse($d1)->addDay()->toDateString()) {
            $bite = $this->date($get('bitedate'), (int) substr($d1, 0, 4) - 1);   // a December bite treated in January
        }
        $biteDate = $bite['date'] ?? $d1;
        if (!$biteDate) {
            throw new InvalidArgumentException('Missing or unreadable date of bite.');
        }
        if ($biteDate < '2000-01-01' || $biteDate > date('Y-m-d', strtotime('+1 day'))) {
            throw new InvalidArgumentException("Date of bite ({$biteDate}) is outside the plausible range.");
        }
        if ($biteDate < $dob) {
            throw new InvalidArgumentException('Date of bite is before the birthdate.');
        }
        if ($d1 && $bite && $biteDate !== $d1) {
            $gap = (int) Carbon::parse($biteDate)->diffInDays(Carbon::parse($d1), false);   // + = dose after the bite
            if ($gap < -1) {
                throw new InvalidArgumentException("Date of bite ({$biteDate}) is after the 1st dose ({$d1}) - please check the dates.");
            }
            if ($gap > 366) {
                throw new InvalidArgumentException("Date of bite ({$biteDate}) is more than a year before the 1st dose ({$d1}) - please check the dates.");
            }
        }
        $biteAt = $biteDate . ' ' . (($bite['time'] ?? null) ?: '00:00:00');

        // --- demographics
        $sex = match (strtoupper(substr($get('sex'), 0, 1))) {
            'M' => 'Male', 'F' => 'Female',
            default => throw new InvalidArgumentException('Gender must be M or F.'),
        };
        $ageText = $get('age');
        $age = preg_match('/^\s*(\d{1,3})\s*(y|yr|yrs|years?)?\s*$/i', $ageText, $m)
            ? (int) $m[1]
            : (int) Carbon::parse($dob)->diffInYears(Carbon::parse($biteDate));   // "5 MOS", blank ... -> work it out
        if ($ageText !== '' && !is_numeric($ageText) && preg_match('/mo|day|wk|week/i', $ageText)) {
            $age = 0;
        }

        $rawBrgy = $get('barangay');
        if ($rawBrgy === '') {
            throw new InvalidArgumentException('Missing barangay.');
        }
        $key = $this->norm($rawBrgy);
        $brgy = $this->barangays[$key] ?? self::BARANGAY_ALIASES[$key] ?? null;
        if ($brgy === null) {
            $brgy = mb_convert_case(mb_strtolower($rawBrgy), MB_CASE_TITLE);
            // "Others (Mandaue)" and the like are patients from outside Cebu City: expected, so one combined note
            $group = preg_match('/^OTHERS?/', $key) ? 'outside' : $brgy;
            $unknownBarangays[$group] = ($unknownBarangays[$group] ?? 0) + 1;
        }

        // --- case
        $category = $this->category($get('category'));

        $animalRaw = strtoupper($get('animal'));
        [$animal, $animalOther] = match (true) {
            $animalRaw === 'D', str_starts_with($animalRaw, 'DOG') => ['Dog', null],
            $animalRaw === 'C', str_starts_with($animalRaw, 'CAT') => ['Cat', null],
            default => ['Others', $animalRaw !== '' ? mb_convert_case(mb_strtolower($animalRaw), MB_CASE_TITLE) : null],
        };

        $vax = strtoupper($get('animalvax'));
        $animalVax = match (true) {
            $vax === 'V', str_starts_with($vax, 'VAC') => 'Vaccinated',
            $vax === 'U', str_starts_with($vax, 'UNVAC') => 'Unvaccinated',
            default => 'Unknown',
        };

        $circ = strtoupper($get('circ'));
        // P = provoked; U / UP = unprovoked (the monthly sheets switch between the two spellings)
        $provoked = $circ === 'P' || str_starts_with($circ, 'PROV') ? 1 : (in_array($circ, ['U', 'UP'], true) || str_starts_with($circ, 'UNPROV') ? 0 : null);
        $circParts = [];
        if ($provoked !== null) { $circParts[] = $provoked ? 'Provoked' : 'Unprovoked'; }
        $strayText = $get('stray');
        if ($strayText !== '') { $circParts[] = 'Stray animal' . (strtoupper($strayText) !== 'S' ? ' (' . $strayText . ')' : ''); }

        // --- treatment
        $doses = [
            'day0'  => $d1,
            'day3'  => $this->date($get('d2'))['date'] ?? null,
            'day7'  => $this->date($get('d3'))['date'] ?? null,
            'day28' => $this->date($get('d28'))['date'] ?? null,
        ];
        $given = count(array_filter([$doses['day0'], $doses['day3'], $doses['day7']]));

        $outRaw = $get('outcome');
        $outcome = self::OUTCOME_CODES[$outRaw] ?? null;
        if ($outcome === null && $outRaw !== '') {
            $o = strtolower($outRaw);
            $outcome = match (true) {
                str_starts_with($o, 'complete') => 'Completed',
                str_starts_with($o, 'incomplete') => 'Incomplete',
                str_contains($o, 'lost') => 'Lost to Follow-up',
                str_contains($o, 'discharg') => 'Discharged (Cat. I)',
                default => null,
            };
        }
        if ($outcome === null && $doses['day0']) {
            $outcome = $given >= 3 ? 'Completed' : 'Incomplete';
        }
        if ($category === 'I' && $outcome === null) {
            $outcome = 'Discharged (Cat. I)';
        }

        $brandRaw = strtoupper($get('vaccine'));
        $brand = null;
        foreach (self::VACCINES as $k => $v) {
            if ($brandRaw !== '' && str_contains($brandRaw, $k)) { $brand = $v; break; }
        }
        $vaccineNote = null;
        if ($brand === null && $brandRaw !== '') {
            // the untitled column after the 3rd dose sometimes holds a date instead of a brand: a late dose around day 28
            $late = $this->date($get('vaccine'))['date'] ?? null;
            if ($late && $doses['day0'] && !$doses['day28']) {
                $days = (int) Carbon::parse($doses['day0'])->diffInDays(Carbon::parse($late), false);
                if ($days >= 20 && $days <= 40) {
                    $doses['day28'] = $late;
                }
            } elseif (!$late) {
                $vaccineNote = 'Vaccine column: ' . $get('vaccine');   // e.g. "C/O MAXICARE" - kept as a note, not as a brand
            }
        }

        $hrig = $get('hrig');
        $erig = $get('erig');
        $passive = $hrig !== '' ? 'HRIG (BERIRAB)' : ($erig !== '' ? 'ERIG (EQUIRAB)' : null);

        // --- wound
        [$totalWounds, $woundText] = $this->wound($get('wound'));

        $contact = preg_replace('/[^0-9+]/', '', $get('contact'));

        return [
            'dedupe'   => mb_strtolower($name) . '|' . $dob . '|' . $biteDate,
            'name'     => $name, 'dob' => $dob, 'age' => $age, 'sex' => $sex, 'barangay' => $brgy,
            'contact'  => mb_substr($contact, 0, 20),
            'bite_at'  => $biteAt, 'category' => $category, 'outcome' => $outcome,
            'animal'   => $animal, 'animal_other' => $animalOther, 'animal_vax' => $animalVax,
            'provoked' => $provoked, 'circumstances' => $circParts ? implode('. ', $circParts) : null,
            'doses'    => $doses, 'brand' => $brand, 'dose_type' => $get('booster') !== '' ? 'Booster' : 'Primary',
            'passive'  => $passive, 'total_wounds' => $totalWounds, 'wound_text' => $woundText,
            'site'     => mb_substr($get('site'), 0, 100) ?: null,
            'remarks'  => implode(' | ', array_filter([$get('remarks'), $vaccineNote])) ?: null,
        ];
    }

    private function cleanName(string $raw): string
    {
        $raw = trim(preg_replace('/\s+/', ' ', $raw));
        return mb_substr(mb_convert_case(mb_strtolower($raw), MB_CASE_TITLE), 0, 100);
    }

    private function category(string $raw): string
    {
        $r = strtoupper(preg_replace('/[^A-Z0-9]/', '', $raw));
        return match (true) {
            $r === '' => throw new InvalidArgumentException('Missing exposure category (I, II or III).'),
            str_ends_with($r, 'III'), $r === '3' => 'III',
            str_ends_with($r, 'II'), $r === '2' => 'II',
            str_ends_with($r, 'I'), $r === '1' => 'I',
            default => throw new InvalidArgumentException("Unknown exposure category \"{$raw}\" (use I, II or III)."),
        };
    }

    /** "S-AB", "M-P&AB", "SP", "NOT VISIBLE" ... => [Single|Multiple|null, readable text|null] */
    private function wound(string $raw): array
    {
        if ($raw === '') {
            return [null, null];
        }
        $u = strtoupper(trim($raw));
        $total = null;
        $rest = $u;
        if (preg_match('/^(S|M)(?![A-Z]{3,})\s*[-\/]?\s*(.*)$/', $u, $m) && $m[2] !== '') {
            $total = $m[1] === 'S' ? 'Single' : 'Multiple';
            $rest = $m[2];
        }
        $words = ['P' => 'puncture', 'AB' => 'abrasion', 'L' => 'laceration', 'LAC' => 'laceration', 'C' => 'contusion',
            'A' => 'avulsion', 'S' => 'scratch', 'SC' => 'scratch', 'B' => 'bruise'];
        $parts = [];
        foreach (preg_split('/[\s,&\/+-]+/', $rest) as $tok) {
            if ($tok === '') { continue; }
            if (!isset($words[$tok])) { $parts = null; break; }
            $parts[] = $words[$tok];
        }
        if ($total && $parts) {
            return [$total, ucfirst(strtolower($total)) . ' wound: ' . implode(', ', array_unique($parts)) . " ({$raw})"];
        }
        return [$total, mb_convert_case(mb_strtolower($raw), MB_CASE_TITLE)];
    }

    /**
     * Understands ISO dates, m/d/yy[yy] text (US order, the way the sheets were typed) with an optional time,
     * and "N/A"-style filler. Returns ['date' => 'Y-m-d', 'time' => 'H:i:s'|null] or [].
     */
    private function date(string $raw, ?int $yearHint = null): array
    {
        $s = trim($raw);
        if ($s === '' || !preg_match('/\d/', $s)) {
            return [];
        }
        $y = $mo = $d = null;
        $guessed = false;
        // an impossible time typed in the sheet ("21:60") is dropped; the date is still used
        $clock = fn (int $h, int $min): ?string => $h <= 23 && $min <= 59 ? sprintf('%02d:%02d:00', $h, $min) : null;
        $timeOf = function (string $rest) use ($clock): ?string {
            if (preg_match('/(\d{1,2})(?::(\d{2}))?\s*([ap])\.?m?\.?/i', $rest, $t)) {
                return $clock((int) $t[1] % 12 + (strtolower($t[3]) === 'p' ? 12 : 0), (int) ($t[2] ?? 0));
            }
            if (preg_match('/(\d{1,2}):(\d{2})/', $rest, $t)) {
                return $clock((int) $t[1], (int) $t[2]);
            }
            return null;
        };
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})(?:[ T](\d{1,2}):(\d{2}))?/', $s, $m)) {
            [$y, $mo, $d] = [(int) $m[1], (int) $m[2], (int) $m[3]];
            $time = isset($m[4]) ? $clock((int) $m[4], (int) $m[5]) : null;
        } elseif (preg_match('/(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{2,4})(.*)$/', $s, $m)) {
            [$a, $b, $y] = [(int) $m[1], (int) $m[2], (int) $m[3]];
            [$mo, $d] = $a > 12 && $b <= 12 ? [$b, $a] : [$a, $b];   // 25/12/24 can only be day/month
            if ($y < 100) { $y += 2000; }
            $time = $timeOf($m[4]);
        } elseif ($yearHint && preg_match('/^(\d{1,2})[\/\-.](\d{1,2})(?![\d\/\-.])(.*)$/', $s, $m)) {
            // month/day without a year, e.g. "10/5, 3PM"
            [$a, $b] = [(int) $m[1], (int) $m[2]];
            [$mo, $d] = $a > 12 && $b <= 12 ? [$b, $a] : [$a, $b];
            $y = $yearHint;
            $guessed = true;
            $time = $timeOf($m[3]);
        } else {
            return [];
        }
        if (!checkdate($mo, $d, $y)) {
            return [];
        }
        return ['date' => sprintf('%04d-%02d-%02d', $y, $mo, $d), 'time' => $time, 'guessed' => $guessed];
    }

    /** The year written in a file name ("2025-ANIMAL-BITE-CASES.xlsx"), used for dates that have no year. */
    public static function yearFromFilename(string $name): ?int
    {
        return preg_match('/(?<!\d)(20\d{2})(?!\d)/', $name, $m) ? (int) $m[1] : null;
    }

    /** Year to assume for bite dates written without one, and the year of month-named tabs. */
    public function forYear(?int $year): static
    {
        $this->yearHint = $year;
        return $this;
    }

    /** Month number (1-12) when a tab is named after a month (JANUARY, Feb, ...), else null. */
    private function monthOfTab(string $name): ?int
    {
        $n = strtoupper(trim($name));
        foreach (['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $i => $full) {
            if ($n === $full || $n === substr($full, 0, 3) || ($n === 'SEPT' && $i === 8)) {
                return $i + 1;
            }
        }
        return null;
    }

    // ------------------------------------------------------------------ writing

    private function preload(): void
    {
        DB::table('inflow_general_particulars')
            ->select('patient_name', 'date_of_birth', 'queue_date', 'queue_id')
            ->orderBy('inflow_record_id')
            ->chunk(5000, function ($rows) {
                foreach ($rows as $r) {
                    $this->seen[mb_strtolower($r->patient_name) . '|' . $r->date_of_birth . '|' . $r->queue_date] = true;
                    if (str_starts_with((string) $r->queue_id, 'H')) {
                        $seq = (int) substr((string) $r->queue_id, 1);
                        if ($seq > ($this->queueSeq[$r->queue_date] ?? 0)) {
                            $this->queueSeq[$r->queue_date] = $seq;
                        }
                    }
                }
            });

        DB::table('patients')->select('patient_id', 'patient_name', 'date_of_birth')
            ->orderBy('patient_id')
            ->chunk(5000, function ($rows) {
                foreach ($rows as $r) {
                    $this->patients[mb_strtolower($r->patient_name) . '|' . $r->date_of_birth] = $r->patient_id;
                    $pos = strrpos((string) $r->patient_id, '-');
                    if ($pos !== false) {
                        $prefix = substr((string) $r->patient_id, 0, $pos);
                        $this->patientSeq[$prefix] = ($this->patientSeq[$prefix] ?? 0) + 1;
                    }
                }
            });

        foreach (DB::table('bite_cases')->select('patient_id', DB::raw('MAX(case_number) as n'))->groupBy('patient_id')->get() as $r) {
            $this->caseNo[$r->patient_id] = (int) $r->n;
        }
    }

    private function flushBuffers(): void
    {
        if ($this->bufSec3) {
            DB::table('bite_section3_exposure')->insert($this->bufSec3);
            $this->bufSec3 = [];
        }
        if ($this->bufSec6) {
            DB::table('bite_section6_wound_description')->insert($this->bufSec6);
            $this->bufSec6 = [];
        }
        if ($this->bufSec7) {
            DB::table('bite_section7_immunization')->insert($this->bufSec7);
            $this->bufSec7 = [];
        }
        if ($this->bufSec8) {
            DB::table('bite_section8_remarks')->insert($this->bufSec8);
            $this->bufSec8 = [];
        }
    }

    /** @return bool true when a new patient record was created */
    private function store(array $r): bool
    {
        $day = substr($r['bite_at'], 0, 10);
        $nextQueue = ($this->queueSeq[$day] ?? 0) + 1;
        $queueId = 'H' . $nextQueue;

        $inflowId = DB::table('inflow_general_particulars')->insertGetId([
            'queue_id'          => $queueId,
            'queue_date'        => $day,
            'patient_name'      => $r['name'],
            'age'               => $r['age'],
            'sex'               => $r['sex'],
            'date_of_birth'     => $r['dob'],
            'civil_status'      => 'Single',
            'contact_num'       => $r['contact'],
            'barangay'          => $r['barangay'],
            'philhealth_member' => 0,
            'reg_date'          => $r['bite_at'],
            'status'            => 'Encoded',
        ]);

        $personKey = mb_strtolower($r['name']) . '|' . $r['dob'];
        $isNew = !isset($this->patients[$personKey]);
        if ($isNew) {
            $prefix = 'CEB-' . str_replace('-', '', $day) . '-' . str_replace('-', '', $r['dob']);
            $nextPatientSeq = ($this->patientSeq[$prefix] ?? 0) + 1;
            $patientId = $prefix . '-' . str_pad((string) $nextPatientSeq, 3, '0', STR_PAD_LEFT);
            DB::table('patients')->insert([
                'patient_id'        => $patientId,
                'inflow_record_id'  => $inflowId,
                'date_registered'   => $r['bite_at'],
                'patient_name'      => $r['name'],
                'age'               => $r['age'],
                'sex'               => $r['sex'],
                'date_of_birth'     => $r['dob'],
                'civil_status'      => 'Single',
                'contact_num'       => $r['contact'],
                'philhealth_member' => 0,
            ]);
            $this->patientSeq[$prefix] = $nextPatientSeq;
            $this->patients[$personKey] = $patientId;
        } else {
            $patientId = $this->patients[$personKey];
        }

        $caseNumber = ($this->caseNo[$patientId] ?? 0) + 1;
        $caseId = DB::table('bite_cases')->insertGetId([
            'patient_id'        => $patientId,
            'inflow_record_id'  => $inflowId,
            'case_number'       => $caseNumber,
            'date_verified'     => $r['bite_at'],
            'barangay'          => $r['barangay'],
            'category'          => $r['category'],
            'philhealth_status' => 'Not a Member',
            'outcome'           => $r['outcome'],
        ]);

        $this->bufSec3[] = [
            'bite_case_id'      => $caseId,
            'animal_type'       => $r['animal'],
            'animal_type_other' => $r['animal_other'],
            'bite_date_time'    => $r['bite_at'],
            'animal_vax_status' => $r['animal_vax'],
            'exposure_type'     => 'Bite',
            'is_provoked'       => $r['provoked'],
            'circumstances'     => $r['circumstances'],
        ];

        $this->bufSec6[] = [
            'bite_case_id'         => $caseId,
            'total_wounds'         => $r['total_wounds'],
            'wound_description'    => $r['wound_text'],
            'site_of_bite'         => $r['site'],
            'category_of_exposure' => $r['category'],
        ];

        $d = $r['doses'];
        if ($r['category'] !== 'I' || array_filter($d) || $r['passive']) {
            $this->bufSec7[] = [
                'bite_case_id'  => $caseId,
                'vaccine_brand' => $r['brand'],
                'dose_type'     => $r['dose_type'],
                'day0_date'     => $d['day0'],
                'day3_date'     => $d['day3'],
                'day7_date'     => $d['day7'],
                'day28_date'    => $d['day28'],
                'passive_given' => $r['passive'] ? 1 : 0,
                'passive_type'  => $r['passive'],
            ];
        }

        if ($r['remarks']) {
            $this->bufSec8[] = ['bite_case_id' => $caseId, 'advice' => $r['remarks']];
        }

        if (count($this->bufSec3) >= 250) {
            $this->flushBuffers();
        }

        $this->queueSeq[$day] = $nextQueue;
        $this->caseNo[$patientId] = $caseNumber;

        return $isNew;
    }
}