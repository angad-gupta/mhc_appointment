<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/AdminLTE.min.css') }}">

</head>
<body onload="window.print()">
<table class="table">
    <thead>
    <tr>
        <td>
            <h3>{{ config('app.name') }}</h3>
            <p>{{ nl2br(e( is_object($invoice_setting) ? $invoice_setting->address : 'xxx-xxx-xxxx')) }}</p>
            <table>
                <thead>
                <tr>
                    <td>Cell</td>
                    <td> :</td>
                    <td>{{ is_object($invoice_setting) ? $invoice_setting->phone : 'xxx-xxx-xxxx' }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> :</td>
                    <td> {{ is_object($invoice_setting) ? $invoice_setting->email : 'xxx@xxx.xx' }}</td>
                </tr>
                </thead>
            </table>
        </td>
        <td align="right">
            <h3>Invoice</h3>
            <table>
                <thead>
                <tr>
                    <td>Date</td>
                    <td>:</td>
                    <td align="right">{{ $payment->created_at->format('d-M-Y') }} </td>
                </tr>
                <tr>
                    <td>Invoice ID</td>
                    <td>:</td>
                    <td align="right">#{{ str_pad($payment->id,4,'0', STR_PAD_LEFT) }}</td>
                </tr>
                {{-- <tr>
                    <td>Att</td>
                    <td>:</td>
                    <td align="right">{{ $payment->createdBy->full_name }}</td>
                </tr> --}}
                <tr>
                    <td>Patient</td>
                    <td>:</td>
                    <td align="right">{{ $payment->patient->full_name }}</td>
                </tr>
                </thead>
            </table>
        </td>
    </tr>
    </thead>
</table>

<div class="row" style="padding: 15px;">
    <div class="col-md-12">
        <h4>Dear {{ $payment->patient->full_name }},</h4>
        <p>{{ is_object($invoice_setting) ? $invoice_setting->invoice_text : 'Thank you for you payment' }}</p>
    </div>
</div>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Doctor</th>
        <th>Appointment Date</th>
        <th>Consultancy Fees ({{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }})</th>
        <th>Total ({{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }})</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $payment->appointment->doctor->full_name }}</td>
        <td>{{ \Carbon\Carbon::parse($payment->appointment->schedule_date)->format('l d-M-Y') }} <br> {{ $payment->appointment->schedule_time }}</td>
        <td>{{ number_format($payment->payment_amount, 2) }}</td>
        <td><b>{{ number_format($payment->payment_amount, 2) }}</b></td>
    </tr>
    </tbody>
    <tfooter>
        <tr>
            <td colspan="4" align="right">Total</td>
            <td><b>{{ number_format($payment->payment_amount, 2) }} {{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }}</b></td>
        </tr>
        <tr>
            <td colspan="5">
                <p style="text-transform: capitalize;">{{ number_to_word($payment->payment_amount) }} {{ is_object($invoice_setting) ? $invoice_setting->currency_name : 'dollar' }}
                    only.</p>
            </td>
        </tr>
    </tfooter>
</table>


</body>
</html>