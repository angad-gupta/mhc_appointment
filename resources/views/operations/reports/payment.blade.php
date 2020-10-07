<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>payment</title>
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
        <th colspan="4" style="text-align: center;">Payment Report</th>
    </tr>

    @php
        $patient = null;
        $user = null;
        $doctor = null;
        if(request()->query('patient') != null){
            $patient = \App\Models\Patient::find(request()->query('patient'));
        }

        if(request()->query('doctor') != null){
            $doctor = \App\Models\Doctor::find(request()->query('doctor'));
        }

        if(request()->query('taken_by') != null){
            $user = \App\User::find(request()->query('taken_by'));
        }
    @endphp

    <tr>
        <th>Total</th>
        <th>{{ $payments->count() }}</th>
        <th>Date Range</th>
        <th>{{ request()->query('date_range') }}</th>
    </tr>
    <tr>
        <th>Patient</th>
        <th>{{ $patient ? $patient->title .' '. $patient->full_name : '' }}</th>
        <th>Doctor</th>
        <th>{{ $doctor ? $doctor->title . ' '. $doctor->full_name : '' }}</th>
    </tr>
    <tr>
        <th>taken_by</th>
        <th>{{ $user ? $user->full_name : '' }}</th>
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
        <th>Date</th>
        <th>Patient</th>
        <th>Appointment</th>
        <th>Amount</th>
        <th>P. Type</th>
        <th>P. Info</th>
        <th>Paid to</th>
        <th>Taken by</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments->chunk(100) as $chunk)
        @foreach($chunk as $key=>$payment)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                <td>
                    {{ $payment->patient->title }} {{ $payment->patient->full_name }}
                </td>
                <td>
                    {{ $payment->appointment->search_id }}
                </td>
                <td>{{ $payment->payment_amount }}</td>
                <td>{{ $payment->payment_type }}</td>
                <td>{{ $payment->payment_info }}</td>
                <td>
                    {{ $payment->doctor->title . ' ' . $payment->doctor->full_name }}
                </td>
                {{-- <td>{{ $payment->createdBy->full_name }}</td> --}}
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>


</body>
</html>