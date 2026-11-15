<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; font-family: Arial, sans-serif; }
        td, th { border: 1px solid #c1c7d3; padding: 4px 8px; font-size: 10pt; vertical-align: middle; }
        .title  { font-size: 16pt; font-weight: bold; color: #004A93; border: none; text-align: center; }
        .sub    { font-size: 11pt; color: #49607f; border: none; text-align: center; }
        .meta   { border: none; font-size: 10pt; }
        .head   { background-color: #004A93; color: #ffffff; font-weight: bold; text-align: center; }
        .alt    { background-color: #f2f4f6; }
        .txt    { mso-number-format:"\@"; }
        .center { text-align: center; }
        .sum    { background-color: #e5eefb; font-weight: bold; }
    </style>
</head>
<body>
<table>
    <tr><td colspan="12" class="title">Cebu City Health Department</td></tr>
    <tr><td colspan="12" class="sub">Animal Bite Treatment Center - Detailed Monthly Export</td></tr>
    <tr><td colspan="12" class="meta"><b>Month:</b> {{ $monthLabel }}</td></tr>
    <tr><td colspan="12" class="meta"><b>Generated:</b> {{ now()->format('F d, Y h:i A') }}</td></tr>
    @if(!empty($appliedFilters))
    <tr><td colspan="12" class="meta"><b>Filters:</b> {{ collect($appliedFilters)->map(fn($v, $k) => "$k: $v")->implode(' | ') }}</td></tr>
    @endif
    <tr><td colspan="12" class="meta">&nbsp;</td></tr>

    <tr>
        <th class="head">#</th>
        <th class="head">Queue Date</th>
        <th class="head">Queue ID</th>
        <th class="head">Case ID</th>
        <th class="head">Case No.</th>
        <th class="head">Patient Name</th>
        <th class="head">Age</th>
        <th class="head">Sex</th>
        <th class="head">Barangay</th>
        <th class="head">Contact</th>
        <th class="head">Category</th>
        <th class="head">Outcome</th>
    </tr>

    @forelse($records as $i => $r)
        <tr class="{{ $i % 2 ? 'alt' : '' }}">
            <td class="center">{{ $i + 1 }}</td>
            <td class="center txt">{{ \Carbon\Carbon::parse($r->queue_date)->format('M d, Y') }}</td>
            <td class="center">{{ $r->queue_id }}</td>
            <td class="center">{{ $r->bite_case_id ?? '-' }}</td>
            <td class="center">{{ $r->case_number ?? '-' }}</td>
            <td>{{ $r->patient_name }}</td>
            <td class="center">{{ $r->age }}</td>
            <td class="center">{{ $r->sex }}</td>
            <td>{{ $r->barangay }}</td>
            <td class="txt">{{ $r->contact_num }}</td>
            <td class="center"><b>{{ $r->category ?? '-' }}</b></td>
            <td class="center">{{ $r->outcome ?? '-' }}</td>
        </tr>
    @empty
        <tr><td colspan="12" class="center">No records found for this month.</td></tr>
    @endforelse

    <tr>
        <td colspan="5" class="sum">TOTAL RECORDS</td>
        <td colspan="7" class="sum">{{ $records->count() }}</td>
    </tr>
</table>
</body>
</html>