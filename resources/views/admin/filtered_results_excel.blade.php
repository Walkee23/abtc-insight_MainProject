{{-- Filtered Analytics results as an Excel sheet (HTML table saved as .xls, like the annual exports).
     This view prints everything down to the column headings; visualAnalyticsController::exportCsv streams the rows after it.

     Excel's HTML import only honours the FIRST class of a cell, so every cell uses exactly one class and each
     class carries all of its styling (n/nz = centred, t/tz = text on the left, d/dz = date, b/bz = bold centred;
     the "z" versions are the grey banded rows). $widths are the column widths in px, worked out from the data. --}}
@php
    $cols = 9;
    $headerRow = 6 + count($filters);
    $headings = ['NO.', 'DATE', 'PATIENT NAME', 'AGE', 'SEX', 'BARANGAY', 'HEALTH AREA', 'CATEGORY', 'OUTCOME'];
@endphp
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    {{-- Excel-only settings (sheet name, header row stays visible while scrolling). Built as a string because
         Blade would otherwise read the <x:...> tags as its own component tags. --}}
    @php
        $msoSettings = '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
            . '<x:Name>Filtered Results</x:Name>'
            . '<x:WorksheetOptions><x:Selected/><x:FreezePanes/><x:FrozenNoSplit/>'
            . '<x:SplitHorizontal>' . $headerRow . '</x:SplitHorizontal><x:TopRowBottomPane>' . $headerRow . '</x:TopRowBottomPane>'
            . '<x:ActivePane>2</x:ActivePane><x:Panes><x:Pane><x:Number>3</x:Number></x:Pane><x:Pane><x:Number>2</x:Number></x:Pane></x:Panes>'
            . '</x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
    @endphp
    {!! $msoSettings !!}
    <style>
        table { border-collapse: collapse; font-family: Arial, sans-serif; }
        td, th { border: 1px solid #000000; padding: 3px 8px; font-size: 10pt; vertical-align: middle; white-space: nowrap; }
        .title  { font-size: 15pt; font-weight: bold; color: #004A93; border: none; text-align: center; }
        .sub    { font-size: 11pt; color: #49607f; border: none; text-align: center; }
        .meta   { border: none; font-size: 10pt; text-align: left; }
        .metab  { border: none; font-size: 10pt; text-align: left; font-weight: bold; }
        .head   { background-color: #ffff00; font-weight: bold; text-align: center; }
        .n      { text-align: center; }
        .nz     { text-align: center; background-color: #f2f2f2; }
        .t      { text-align: left; mso-number-format: "\@"; }
        .tz     { text-align: left; mso-number-format: "\@"; background-color: #f2f2f2; }
        .d      { text-align: center; mso-number-format: "mmm\ dd\,\ yyyy"; }
        .dz     { text-align: center; mso-number-format: "mmm\ dd\,\ yyyy"; background-color: #f2f2f2; }
        .b      { text-align: center; font-weight: bold; }
        .bz     { text-align: center; font-weight: bold; background-color: #f2f2f2; }
        .grand  { font-weight: bold; text-align: center; background-color: #d9eef3; }
        .grandl { font-weight: bold; text-align: right; background-color: #d9eef3; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script src="{{ asset('js/mobile-nav.js') }}" defer></script>
</head>
<body>
<table>
    @foreach ($widths as $w)
        <col width="{{ $w }}" style="width:{{ $w }}px; mso-width-source:userset;">
    @endforeach
    <tr><td colspan="{{ $cols }}" class="title">Cebu City Health Department</td></tr>
    <tr><td colspan="{{ $cols }}" class="sub">Animal Bite Treatment Center - Filtered Analytics Results</td></tr>
    <tr><td colspan="{{ $cols }}" class="meta"><b>Generated:</b> {{ now()->format('F d, Y h:i A') }}</td></tr>
    @foreach ($filters as $label => $value)
        <tr><td colspan="2" class="metab">{{ $label }}</td><td colspan="{{ $cols - 2 }}" class="meta">{{ $value }}</td></tr>
    @endforeach
    <tr><td colspan="2" class="metab">Total cases</td><td colspan="{{ $cols - 2 }}" class="meta">{{ number_format($total) }}</td></tr>
    <tr><td colspan="{{ $cols }}" class="meta">&nbsp;</td></tr>

    <tr>
        @foreach ($headings as $i => $heading)
            <th class="head" style="width:{{ $widths[$i] }}px;">{{ $heading }}</th>
        @endforeach
    </tr>
