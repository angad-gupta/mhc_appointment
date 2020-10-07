<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

<h5>Report of drug : {{ $_drug->trade_name }}</h5>

<table width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Prescription ID</th>
        <th>Patient</th>
        <th>Date</th>
    </tr>
    </thead>

    <tbody>
    @foreach($prescription_drugs as $key=>$prescription_drug)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $prescription_drug->prescription->search_id }}</td>
            <td>{{ $prescription_drug->prescription->patient->full_name }}</td>
            <td>{{ $prescription_drug->created_at->format('d-M-Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>