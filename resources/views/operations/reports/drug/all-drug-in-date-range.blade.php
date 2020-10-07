<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Drug Report</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<h5>Drug report of  : {{ $range[0]. ' to '. $range[1] }}</h5>

<table class="table" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Trade Name</th>
        <th>Generic Name</th>
        <th>Number of use</th>
    </tr>
    </thead>
    <tbody>
    @foreach($_drugs as $key=>$drug)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $drug->trade_name }}</td>
            <td>{{ $drug->generic_name }}</td>
            <td>{{ \App\Models\PrescriptionDrug::where('name', $drug->trade_name)->whereBetween('created_at', [\Carbon\Carbon::parse($range[0])->toDateString(),\Carbon\Carbon::parse($range[1])->toDateString()])->count() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>