<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; font-family: Arial, sans-serif; }
        td, th { border: 1px solid #000000; padding: 3px 6px; font-size: 10pt; text-align: center; vertical-align: middle; }
        .title { font-size: 15pt; font-weight: bold; color: #004A93; border: none; }
        .sub   { font-size: 11pt; color: #49607f; border: none; }
        .meta  { border: none; font-size: 10pt; text-align: left; }
        .grp   { font-weight: bold; background-color: #ffffff; }
        .col   { font-weight: bold; background-color: #ffffff; font-size: 9pt; }
        .label { text-align: left; font-weight: bold; }
        .qtr   { background-color: #d9d9d9; font-weight: bold; }
        .year  { background-color: #bfbfbf; font-weight: bold; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>
<body>
<table>
    <tr><td colspan="16" class="title">Cebu City Health Department</td></tr>
    <tr><td colspan="16" class="sub">Animal Bite Treatment Center - Annual Report {{ $year }}</td></tr>
    <tr><td colspan="16" class="meta"><b>Generated:</b> {{ now()->format('F d, Y h:i A') }}</td></tr>
    <tr><td colspan="16" class="meta">&nbsp;</td></tr>

    {{-- HEADER ROW 1 --}}
    <tr>
        <th rowspan="3" class="grp">MONTH</th>
        <th colspan="2" rowspan="2" class="grp">SEX</th>
        <th colspan="2" rowspan="2" class="grp">AGE</th>
        <th colspan="3" rowspan="2" class="grp">BITING ANIMAL</th>
        <th colspan="5" class="grp">HUMAN CASE</th>
        <th colspan="3" rowspan="2" class="grp">POST-EXPOSURE PROPHYLAXIS</th>
    </tr>
    <tr>
        <th colspan="5" class="grp">ANIMAL BITE CASE</th>
    </tr>
    {{-- HEADER ROW 3 --}}
    <tr>
        <th class="col">MALE</th>
        <th class="col">FEMALE</th>
        <th class="col">&lt;15 YEARS OLD</th>
        <th class="col">&gt;15 YEARS OLD</th>
        <th class="col">DOG</th>
        <th class="col">CAT</th>
        <th class="col">OTHERS</th>
        <th class="col">CATEGORY I</th>
        <th class="col">CATEGORY II</th>
        <th class="col">CATEGORY III</th>
        <th class="col">TOTAL</th>
        <th class="col">HR</th>
        <th class="col">TCV</th>
        <th class="col">HRIG</th>
        <th class="col">ERIG</th>
    </tr>

    @foreach ($rows as $r)
        @php
            $d = $r['d'];
            $cls = $r['type'] === 'quarter' ? 'qtr' : ($r['type'] === 'year' ? 'year' : '');
        @endphp
        <tr>
            <td class="label {{ $cls }}">{{ $r['label'] }}</td>
            <td class="{{ $cls }}">{{ $d['male'] }}</td>
            <td class="{{ $cls }}">{{ $d['female'] }}</td>
            <td class="{{ $cls }}">{{ $d['u15'] }}</td>
            <td class="{{ $cls }}">{{ $d['o15'] }}</td>
            <td class="{{ $cls }}">{{ $d['dog'] }}</td>
            <td class="{{ $cls }}">{{ $d['cat'] }}</td>
            <td class="{{ $cls }}">{{ $d['others'] }}</td>
            <td class="{{ $cls }}">{{ $d['c1'] }}</td>
            <td class="{{ $cls }}">{{ $d['c2'] }}</td>
            <td class="{{ $cls }}">{{ $d['c3'] }}</td>
            <td class="{{ $cls }}">{{ $d['total'] }}</td>
            <td class="{{ $cls }}">{{ $d['hr'] }}</td>
            <td class="{{ $cls }}">{{ $d['tcv'] }}</td>
            <td class="{{ $cls }}">{{ $d['hrig'] }}</td>
            <td class="{{ $cls }}">{{ $d['erig'] }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>