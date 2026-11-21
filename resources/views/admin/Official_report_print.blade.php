<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <title>ABTC Comprehensive Official Report</title>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>
<body style="font-family: Arial, sans-serif; color: #191c1e; padding: 20px;">

    @php
        $appliedFilters = $appliedFilters ?? [];
        // Mubo nga label para sa Master List heading
        $periodLabel = $appliedFilters['Period'] ?? ($appliedFilters['Date Range'] ?? 'All Dates');
    @endphp

    <h1 style="color: #004A93; text-align: center; font-size: 18pt; margin-bottom: 0;">Cebu City Health Department</h1>
    <h2 style="color: #49607f; text-align: center; font-size: 13pt; margin-top: 5px;">Animal Bite Treatment Center - Comprehensive Visual Analytics Report</h2>
    <hr style="border: 1px solid #004A93; margin-top: 15px; margin-bottom: 20px;">

    <!-- FILTERS APPLIED -->
    <table border="1" cellspacing="0" cellpadding="6" style="width: 100%; border-collapse: collapse; font-size: 10pt; margin-bottom: 10px;">
        <tr style="background-color: #004A93; color: #ffffff;">
            <th colspan="2" style="text-align: left;">FILTERS APPLIED</th>
        </tr>
        @forelse ($appliedFilters as $label => $value)
            <tr>
                <td style="width: 30%; background-color: #f2f4f6;"><strong>{{ $label }}</strong></td>
                <td>{{ $value }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No filters applied (all records)</td>
            </tr>
        @endforelse
        <tr>
            <td style="background-color: #f2f4f6;"><strong>Records Found</strong></td>
            <td>{{ $totalBites ?? 0 }}</td>
        </tr>
        @if (!empty($dataFrom) && !empty($dataTo))
            <tr>
                <td style="background-color: #f2f4f6;"><strong>Data Coverage</strong></td>
                <td>{{ \Carbon\Carbon::parse($dataFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dataTo)->format('M d, Y') }}</td>
            </tr>
        @endif
    </table>

    <p><strong>Date Generated:</strong> {{ date('F d, Y h:i A') }}</p>
    <br>

    <!-- SECTION 1: Metrics -->
    <h3 style="color: #004A93; border-bottom: 2px solid #e0e3e5; padding-bottom: 5px;">1. Executive Summary Metrics</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="background-color: #f2f4f6; padding: 10px; border: 1px solid #c1c7d3; text-align: center;"><strong style="font-size: 13pt; color: #004A93;">{{ $totalBites ?? 0 }}</strong><br><span style="font-size: 8pt;">Total Bite Cases</span></td>
            <td style="background-color: #f2f4f6; padding: 10px; border: 1px solid #c1c7d3; text-align: center;"><strong style="font-size: 13pt; color: #004A93;">{{ $uniquePatients ?? 0 }}</strong><br><span style="font-size: 8pt;">Unique Patients</span></td>
            <td style="background-color: #f2f4f6; padding: 10px; border: 1px solid #c1c7d3; text-align: center;"><strong style="font-size: 13pt; color: #004A93;">{{ $avgAge ?? 0 }}</strong><br><span style="font-size: 8pt;">Average Age</span></td>
        </tr>
    </table>

    <!-- SECTION 2: Demographics & Visual Bar Charts -->
    <h3 style="color: #004A93; border-bottom: 2px solid #e0e3e5; padding-bottom: 5px; margin-top: 25px;">2. Demographic Breakdown &amp; Visual Charts</h3>

    @php
        // Word-safe bar function gamit ang HTML table cells para siguradong mogawas sa .doc
        $bar = function ($pct, $color) {
            $pct = max(0, min(100, (int) round($pct)));
            $rest = 100 - $pct;
            $html  = '<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;"><tr>';
            if ($pct > 0) {
                $html .= '<td width="'.$pct.'%" bgcolor="'.$color.'" height="16" style="background-color:'.$color.'; height:16px; font-size:1pt; line-height:1pt;">&nbsp;</td>';
            }
            if ($rest > 0) {
                $html .= '<td width="'.$rest.'%" bgcolor="#e0e3e5" height="16" style="background-color:#e0e3e5; height:16px; font-size:1pt; line-height:1pt;">&nbsp;</td>';
            }
            return $html.'</tr></table>';
        };

        $maxAge = max([$age0_12 ?? 0, $age13_19 ?? 0, $age20_39 ?? 0, $age40_59 ?? 0, $age60_up ?? 0]) ?: 1;
        $ageRows = [
            '0-12 yrs'  => $age0_12 ?? 0,
            '13-19 yrs' => $age13_19 ?? 0,
            '20-39 yrs' => $age20_39 ?? 0,
            '40-59 yrs' => $age40_59 ?? 0,
            '60+ yrs'   => $age60_up ?? 0,
        ];
    @endphp

    <p><strong>Sex Distribution Chart:</strong></p>
    <table width="100%" cellspacing="0" cellpadding="4" style="margin-bottom: 15px; font-size: 10pt;">
        <tr>
            <td width="20%">Male ({{ $malePct ?? 0 }}%)</td>
            <td width="70%">{!! $bar($malePct ?? 0, '#004A93') !!}</td>
            <td width="10%" align="right">{{ $maleCount ?? 0 }}</td>
        </tr>
        <tr>
            <td>Female ({{ $femalePct ?? 0 }}%)</td>
            <td>{!! $bar($femalePct ?? 0, '#49607f') !!}</td>
            <td align="right">{{ $femaleCount ?? 0 }}</td>
        </tr>
    </table>

    <p><strong>Age Group Distribution Chart:</strong></p>
    <table width="100%" cellspacing="0" cellpadding="4" style="margin-bottom: 20px; font-size: 10pt;">
        @foreach ($ageRows as $label => $count)
            <tr>
                <td width="25%">{{ $label }}</td>
                <td width="65%">{!! $bar(($count / $maxAge) * 100, '#004A93') !!}</td>
                <td width="10%" align="right">{{ $count }}</td>
            </tr>
        @endforeach
    </table>

    <!-- SECTION 3: Animal Types -->
    <h3 style="color: #004A93; border-bottom: 2px solid #e0e3e5; padding-bottom: 5px; margin-top: 25px;">3. Biting Animal Types (Pet / Stray)</h3>
    @php
        $animalBreakdown = $animalBreakdown ?? [];
        $grandAnimals = collect($animalBreakdown)->flatten()->sum();
    @endphp
    <table border="1" cellspacing="0" cellpadding="6" style="width: 100%; border-collapse: collapse; font-size: 10pt;">
        <tr style="background-color: #004A93; color: #ffffff;">
            <th style="text-align: left;">Animal</th>
            <th>Pet</th>
            <th>Stray</th>
            <th>Not recorded</th>
            <th>Total</th>
        </tr>
        @if ($grandAnimals > 0)
            @foreach ($animalBreakdown as $name => $c)
                <tr>
                    <td><strong>{{ $name }}</strong></td>
                    <td style="text-align: center;">{{ $c['Pet'] }}</td>
                    <td style="text-align: center;">{{ $c['Stray'] }}</td>
                    <td style="text-align: center;">{{ $c['Not recorded'] }}</td>
                    <td style="text-align: center;"><strong>{{ array_sum($c) }}</strong></td>
                </tr>
            @endforeach
            <tr style="background-color: #f2f4f6;">
                <td><strong>TOTAL</strong></td>
                <td style="text-align: center;"><strong>{{ collect($animalBreakdown)->sum('Pet') }}</strong></td>
                <td style="text-align: center;"><strong>{{ collect($animalBreakdown)->sum('Stray') }}</strong></td>
                <td style="text-align: center;"><strong>{{ collect($animalBreakdown)->sum('Not recorded') }}</strong></td>
                <td style="text-align: center;"><strong>{{ $grandAnimals }}</strong></td>
            </tr>
        @else
            <tr>
                <td colspan="5" style="text-align: center; color: #717782;">No animal records found for this filter.</td>
            </tr>
        @endif
    </table>

    <!-- SECTION 4: Top 15 Barangays by Incidence -->
    <h3 style="color: #004A93; border-bottom: 2px solid #e0e3e5; padding-bottom: 5px; margin-top: 25px;">4. Top 15 Barangays by Incidence</h3>
    <table border="1" cellspacing="0" cellpadding="6" style="width: 100%; border-collapse: collapse; font-size: 10pt;">
        <tr style="background-color: #004A93; color: #ffffff;">
            <th style="text-align: left; width: 15%;">Rank</th>
            <th style="text-align: left; width: 60%;">Barangay</th>
            <th style="text-align: left; width: 25%;">Total Cases</th>
        </tr>
        @php $rank = 1; @endphp
        @if(isset($hotspots) && count($hotspots) > 0)
            @foreach ($hotspots as $spot)
                <tr>
                    <td>#{{ $rank++ }}</td>
                    <td>{{ $spot->barangay ?? 'Unknown' }}</td>
                    <td><strong>{{ $spot->total }}</strong> cases</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" style="text-align: center; color: #717782;">No barangay data available.</td>
            </tr>
        @endif
    </table>

    <!-- SECTION 5: Master List -->
    <h3 style="color: #004A93; border-bottom: 2px solid #e0e3e5; padding-bottom: 5px; margin-top: 30px;">5. Master List of Cases ({{ $periodLabel }})</h3>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; font-size: 9pt;">
        <tr style="background-color: #49607f; color: #ffffff;">
            <th>Case ID</th><th>Patient Name</th><th>Age/Sex</th><th>Barangay</th><th>Category</th><th>Queue Date</th>
        </tr>
        @if(isset($records) && count($records) > 0)
            @foreach ($records as $row)
                <tr>
                    <td>{{ $row->bite_case_id ?? 'N/A' }}</td>
                    <td>{{ $row->patient_name ?? 'N/A' }}</td>
                    <td>{{ $row->age ?? 'N/A' }} / {{ $row->sex ?? 'N/A' }}</td>
                    <td>{{ $row->barangay ?? 'N/A' }}</td>
                    <td><strong>{{ $row->category ?? 'N/A' }}</strong></td>
                    <td>{{ $row->queue_date ?? $row->date_verified ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" style="text-align: center; color: #717782; padding: 10px;">No patient records found for the selected filter.</td>
            </tr>
        @endif
    </table>

    <br><br><hr style="border: 0.5px solid #e0e3e5;">
    <p style="font-size: 8pt; color: #717782; text-align: center;">Cebu City Animal Bite Treatment Center Insight System — Comprehensive Analytics Report</p>
</body>
</html>