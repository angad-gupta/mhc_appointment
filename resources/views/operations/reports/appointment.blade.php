<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Appointment</title>

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
        <th colspan="4" style="text-align: center;">Appointment Report</th>
    </tr>
    <tr>
        <th>Total</th>
        <th>{{ $appointments->count() }}</th>
        <th>Date Range</th>
        <th>{{ request()->query('date_range') }}</th>
    </tr>
    <tr>
        <th>Patient</th>
        <th>{{ request()->query('patient') }}</th>
        <th>Doctor</th>
        <th>{{ request()->query('doctor') }}</th>
    </tr>
    <tr>
        <th>Status</th>
        <th>{{ request()->query('status') }}</th>
        <th>Sort By</th>
        <th>{{ request()->query('sort_by') }}</th>
    </tr>
    </thead>
</table>
<hr>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Appointment ID</th>
        <th>Appointment Date</th>
        <th>Follow up</th>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach($appointments->chunk(100) as $chunk)
        @foreach($chunk as $key=>$appointment)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $appointment->search_id }}</td>
                <td>{{ $appointment->schedule_date }}</td>
                <td>{{ $appointment->next_followup }}</td>
                <td>{{ $appointment->patient->title }} {{ $appointment->patient->full_name }}</td>
                <td>{{ $appointment->doctor->title }} {{ $appointment->doctor->full_name }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
</body>
</html>