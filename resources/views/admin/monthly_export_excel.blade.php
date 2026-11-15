@php
    $monthNames = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
    $quarterNames = ['1ST QUARTER','2ND QUARTER','3RD QUARTER','4TH QUARTER'];

    $buildCells = function (array $m) {
        $cells = [];
        for ($q = 0; $q < 4; $q++) {
            $sum = 0;
            for ($i = 1; $i <= 3; $i++) {
                $v = $m[$q * 3 + $i] ?? 0;
                $cells[] = ['v' => $v, 'q' => false];
                $sum += $v;
            }
            $cells[] = ['v' => $sum, 'q' => true];
        }
        return $cells;
    };

    $grand = array_fill(1, 12, 0);
    $colSpan = 19;
@endphp
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; font-family: Arial, sans-serif; }
        td, th { border: 1px solid #000000; padding: 3px 6px; font-size: 10pt; vertical-align: middle; }
        .title  { font-size: 15pt; font-weight: bold; color: #004A93; border: none; text-align: center; }
        .sub    { font-size: 11pt; color: #49607f; border: none; text-align: center; }
        .meta   { border: none; font-size: 10pt; }
        .head   { background-color: #ffff00; font-weight: bold; text-align: center; }
        .headw  { background-color: #ffffff; font-weight: bold; text-align: center; }
        .area   { font-weight: bold; text-align: left; }
        .num    { text-align: center; }
        .qtr    { text-align: center; font-weight: bold; background-color: #ffffff; }
        .total  { text-align: center; font-weight: bold; background-color: #d9eef3; }
        .rate   { text-align: center; }
        .sub-tot{ font-weight: bold; text-align: center; background-color: #f2f2f2; }
        .grand  { font-weight: bold; text-align: center; background-color: #d9eef3; }
    </style>
</head>
<body>
<table>
    <tr><td colspan="{{ $colSpan }}" class="title">Cebu City Health Department</td></tr>
    <tr><td colspan="{{ $colSpan }}" class="sub">Animal Bite Treatment Center - Animal Bite Cases per Barangay, {{ $year }}</td></tr>
    <tr><td colspan="{{ $colSpan }}" class="meta"><b>Generated:</b> {{ now()->format('F d, Y h:i A') }}</td></tr>
    <tr><td colspan="{{ $colSpan }}" class="meta">&nbsp;</td></tr>

    <tr>
        <th class="head" style="width:160px;">&nbsp;</th>
        @for ($q = 0; $q < 4; $q++)
            @for ($i = 0; $i < 3; $i++)
                <th class="head">{{ $monthNames[$q * 3 + $i] }}</th>
            @endfor
            <th class="headw">{{ $quarterNames[$q] }}</th>
        @endfor
        <th class="head">TOTAL NUMBER OF ANIMAL BITE CASES PER BARANGAY</th>
        <th class="head">BITING INCIDENCE RATE</th>
    </tr>

    @foreach ($areas as $areaName => $area)
        @php $areaMonths = array_fill(1, 12, 0); @endphp

        <tr>
            <td colspan="{{ $colSpan }}" class="area" style="background-color: {{ $area['color'] }};">{{ $areaName }}</td>
        </tr>

        @foreach ($area['rows'] as $row)
            @php
                $cells = $buildCells($row['months']);
                $rowTotal = array_sum($row['months']);
                for ($m = 1; $m <= 12; $m++) {
                    $areaMonths[$m] += $row['months'][$m];
                    $grand[$m] += $row['months'][$m];
                }
                $rate = (!empty($row['pop'])) ? number_format(($rowTotal / $row['pop']) * 1000, 3) : '-';
            @endphp
            <tr>
                <td style="background-color: {{ $area['color'] }};">{{ $row['name'] }}</td>
                @foreach ($cells as $c)
                    <td class="{{ $c['q'] ? 'qtr' : 'num' }}" style="{{ $c['q'] ? '' : 'background-color:' . $area['color'] . ';' }}">{{ $c['v'] }}</td>
                @endforeach
                <td class="total">{{ $rowTotal }}</td>
                <td class="rate">{{ $rate }}</td>
            </tr>
        @endforeach

        @php
            $subCells = $buildCells($areaMonths);
            $areaTotal = array_sum($areaMonths);
        @endphp
        <tr>
            <td class="sub-tot">SUBTOTAL</td>
            @foreach ($subCells as $c)
                <td class="sub-tot">{{ $c['v'] }}</td>
            @endforeach
            <td class="sub-tot">{{ $areaTotal }}</td>
            <td class="sub-tot">&nbsp;</td>
        </tr>
    @endforeach

    @php
        $ncCells = $buildCells($nonCebu);
        $ncTotal = array_sum($nonCebu);
        for ($m = 1; $m <= 12; $m++) { $grand[$m] += $nonCebu[$m]; }
    @endphp
    <tr>
        <td class="area" style="background-color:#e7e6e6;">NON-CEBU CITY VOTERS</td>
        @foreach ($ncCells as $c)
            <td class="{{ $c['q'] ? 'qtr' : 'num' }}">{{ $c['v'] }}</td>
        @endforeach
        <td class="total">{{ $ncTotal }}</td>
        <td class="rate">-</td>
    </tr>

    @php
        $grandCells = $buildCells($grand);
        $grandTotal = array_sum($grand);
    @endphp
    <tr>
        <td class="grand">TOTAL NUMBER OF ANIMAL BITE CASES PER MONTH</td>
        @foreach ($grandCells as $c)
            <td class="grand">{{ $c['v'] }}</td>
        @endforeach
        <td class="grand">{{ $grandTotal }}</td>
        <td class="grand">&nbsp;</td>
    </tr>
</table>
</body>
</html>