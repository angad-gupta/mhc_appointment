@extends('mail.layout')

@section('content')
    <style>
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
    </style>
    @if($prescription->doctor->prescriptionSetting)
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

    @if($prescription->appointment->next_followup != null)
        <div class="next-appointment">
            <p>Next Appointment : {{ $prescription->appointment->next_followup }}</p>
        </div>
    @endif

    <div class="signature">
        Sign & Sel
    </div>
@endsection