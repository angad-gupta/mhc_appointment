<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Prescription</title>
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <style>
        @page {
            size: A4 portrait;
        }

        .signature {
            position: fixed;
            bottom: 20px;
            right: 0px;
            border-top: 1px solid;
            width: 200px;
            text-align: right;
        }

        .next-appointment {
            position: fixed;
            bottom: 20px;
            left: 0;
            text-align: left;
        }

        #barcode {
            height: 66px;
            width: 200px;
        }
    </style>
</head>
<body>


{{-- @if($prescription->doctor->prescriptionSetting)
    <table width="100%" style="border-bottom: 1px solid black;">
        <tr>
            <td width="50%" style="text-align: left;">
                @if($prescription->doctor->prescriptionSetting->show_top_left)
                    {!! $prescription->doctor->prescriptionSetting->top_left !!}
                @endif
            </td>
            <td width="50%" style="text-align: right;">
                @if($prescription->doctor->prescriptionSetting->show_top_right)
                    {!! $prescription->doctor->prescriptionSetting->top_right !!}
                @endif
            </td>
        </tr>
    </table>
@endif

<table width="100%">

    @php
        function getAgeAtPrescription($prescription){
            $age = \Carbon\Carbon::parse($prescription->patient->date_of_birth)->diff($prescription->created_at)->format('%y-%m-%d');
            $years = explode("-", $age);
            if($years[0] > 0){
                return $years[0].' Years';
            }elseif ($years[1] > 0){
                return $years[1].' Months';
            }else{
                return $years[2].' Days';
            }
        }
    @endphp

    <tr style="border-bottom: 1px solid;">
        <td>Name : {{ $prescription->patient->full_name }}</td>
        <td>Age : {{ getAgeAtPrescription($prescription) }}</td>
        <td>Gender : {{ $prescription->patient->sex }}</td>
        <td align="right">Prescription Date : {{ $prescription->created_at->format('d-M-Y') }}</td>
    </tr>

</table>

<table width="100%" style="margin-top: 20px;">
    <tr>
        <td width="40%" valign="top" style="border-right: 1px solid black;">
            @if($prescription->inspection->chief_complains)
                <strong>Chief Complains</strong>
                <p>{{ $prescription->inspection->chief_complains }}</p>
            @endif

            @if($prescription->inspection->on_examinations)
                <strong>On Examinations</strong>
                <p>{{ $prescription->inspection->on_examinations }}</p>
            @endif

            @if($prescription->inspection->provisional_diagnosis)
                <strong>Provisional Diagnosis</strong>
                <p>{{ $prescription->inspection->provisional_diagnosis }}</p>
            @endif

            @if($prescription->inspection->differential_diagnosis)
                <strong>Differential Diagnosis</strong>
                <p>{{ $prescription->inspection->differential_diagnosis }}</p>
            @endif

            @if($prescription->inspection->lab_workup)
                <strong>Lab Workup</strong>
                <p>{{ $prescription->inspection->lab_workup }}</p>
            @endif

            @if($prescription->inspection->advices)
                <strong>Advices</strong>
                <p>{{ $prescription->inspection->advices }}</p>
            @endif


        </td>
        <td width="60%" valign="top">
            <h4 style="margin-left: 5px;">Rx</h4>
            <ol>
                @foreach($prescription->drugs as $drug)
                    <li>{{ $drug->type }} {{ $drug->name }} {{ $drug->strength }} <br> {{ $drug->dose }}
                        <br> {{ $drug->advice }}</li>
                @endforeach
            </ol>
        </td>
    </tr>

</table>


<div class="next-appointment">
    @if($prescription->appointment->next_followup != null)
        <p>Next Appointment : {{ $prescription->appointment->next_followup }}</p>
    @endif
    <svg id="barcode"></svg>
</div>


<div class="signature">
    Sign & Sel
</div> --}}

<div class="row" style="background-color: royalblue; margin-top: 30px">
    <div class="col-md-8">
        <h3>Health Choice Clinic</h3>
        <p>Address goes here</p>
        <p>Email goes here</p>
    </div>
    <div class="col-md-4" style="margin-left: 500px; margin-top: -120px">
        <img src="https://www.merohealthcare.com/assets/images/1592375295logo.jpg" alt="">
    </div>
</div>

<div class="row" style="margin-top: 160px;">
    <h5 style="margin-left: 40px"><b>Appointment Information</b></h5>
    <hr>
    <div style="margin-left: 30px">        
        <p>Name: {{ $payment->patient->full_name }}</p>
        <p>Gender: {{ $payment->patient->sex }}</p>
        <p>Address: {{ $payment->patient->address }}</p>
        <p>Contact number: {{ $payment->patient->cell_phone }}</p>
    </div>
    <div style="margin-left: 500px; margin-top: -120px">
        
        <p style="color: royalblue">{{ $payment->doctor->title }}.{{ $payment->doctor->full_name }}</p>
        <p>{{ $payment->doctor->department->title }}</p>
        <p>Appointment Number: {{ $payment->appointment->search_id }}</p>
        <p>Payment Date: {{ $payment->created_at->format('d-M-Y') }}</p>
    </div>
    <br>
    <hr>
</div>

<div class="row" style="margin-top: 30px;margin-left: 30px">
    <h5><b>Payment Information</b></h5>
    <hr>
    <p>{{ $payment->payment_info }}</p>
    <p>Fee: {{ $payment->payment_amount }}</p>
    <p>Payment Date: {{ $payment->created_at->format('d-M-Y') }}</p>
    <p>Payment Method: {{ $payment->payment_method }}</p>
</div>

<div class="row" style="margin-top: 100px; background-color: royalblue">
    <div style="margin-left: 30px">
        <p>Contact number</p>
    </div>
    <div style="margin-left: 500px; margin-top: -40px">
        <p>Email</p>
    </div>
</div>

<div class="next-appointment">
    <svg id="barcode"></svg>
</div>

<script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>

<script>
    JsBarcode("#barcode", '{{ $payment->appointment->search_id }}');
    window.print();
</script>

</body>
</html>