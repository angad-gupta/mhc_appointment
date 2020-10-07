@extends('mail.layout')

@section('content')

    @php
        $invoice_setting = \App\Models\InvoiceSetting::first();
    @endphp

    <table class="table">
        <thead>
        <tr>
            <td>
                <h3></h3>
                <p>{{ nl2br(e( is_object($invoice_setting) ? $invoice_setting->address : 'xxx-xxx-xxxx')) }}</p>
                <table>
                    <thead>
                    <tr>
                        <td>{{ __('actions.phone') }}</td>
                        <td> :</td>
                        <td>{{ is_object($invoice_setting) ? $invoice_setting->phone : 'xxx-xxx-xxxx' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('actions.email') }}</td>
                        <td> :</td>
                        <td> {{ is_object($invoice_setting) ? $invoice_setting->email : 'xxx@xxx.xx' }}</td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td align="right">
                <h3>{{ __('mail.invoice.title') }}</h3>
                <table>
                    <thead>
                    <tr>
                        <td>{{ __('schedule.date') }}</td>
                        <td>:</td>
                        <td align="right">{{ $payment->created_at->format('d-M-Y') }} </td>
                    </tr>
                    <tr>
                        <td>{{ __('mail.invoice.invoice_id') }}</td>
                        <td>:</td>
                        <td align="right">#{{ str_pad($payment->id,4,'0', STR_PAD_LEFT) }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Att</td>
                        <td>:</td>
                        <td align="right">{{ $payment->createdBy->full_name }}</td>
                    </tr> --}}
                    <tr>
                        <td>{{ __('patient.title') }}</td>
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
            <th>{{ __('doctor.doctor') }}</th>
            <th>{{ __('appointment.appointment') }} {{ __('schedule.date') }}</th>
            <th>{{ __('mail.invoice.consultancy_fees') }} ({{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }})</th>
            <th>{{ __('mail.invoice.total') }} ({{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }})</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>{{ $payment->appointment->doctor->full_name }}</td>
            <td>{{ \Carbon\Carbon::parse($payment->appointment->schedule_date)->format('l d-M-Y') }}
                <br> {{ $payment->appointment->schedule_time }}</td>
            <td>{{ number_format($payment->payment_amount, 2) }}</td>
            <td><b>{{ number_format($payment->payment_amount, 2) }}</b></td>
        </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="4" align="right">{{ __('mail.invoice.total') }}</td>
                <td>
                    <b>{{ is_object($invoice_setting) ? $invoice_setting->currency_symbol : '$' }} {{ number_format($payment->payment_amount, 2) }} </b>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p style="text-transform: capitalize;">{{ number_to_word($payment->payment_amount) }} {{ is_object($invoice_setting) ? $invoice_setting->currency_name : 'dollar' }}
                        {{ __('mail.invoice.only') }} </p>
                </td>
            </tr>
        </tfooter>
    </table>
@endsection