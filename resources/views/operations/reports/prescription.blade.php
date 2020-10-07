<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription</title>
    <style>

        .table {
            width: 100%;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

    </style>
</head>
<body>


<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Prescription ID</th>
        <th>Date</th>
        <th>Patient</th>
        <th>Doctor</th>
    </tr>
    </thead>

    <tbody>
    @foreach($prescriptions->chunk(100) as $chunk)
        @foreach($chunk as $key=>$prescription)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $prescription->search_id }}</td>
                <td>{{ $prescription->created_at->format('l d-M-Y') }}</td>
                <td>{{ $prescription->patient->title }} {{ $prescription->patient->full_name }}</td>
                <td>{{ $prescription->doctor->title }} {{ $prescription->doctor->full_name }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

</body>
</html>