@extends('layouts.app')

@section('title')
    {{ $patient->full_name }} Timeline
@endsection

@section('css')
    <style>
        @media screen and (min-width: 720px) {
            #patientBlock {
                position: fixed;
                right: 10%;
                background: #ffffff;
                padding: 10px;
                border-radius: 2px;
            }
        }

        #patientBlock {
            background: #ffffff;
            padding: 10px;
            border-radius: 2px;
            margin-top: 20px;
        }

    </style>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-8">
            <!-- The time line -->
            <ul class="timeline">
            @foreach($patient->appointments as $appointment)
                <!-- timeline time label -->
                    <li class="time-label">
                  <span class="bg-red">
                    {{ \Carbon\Carbon::parse($appointment->schedule_date)->format('d-M-Y') }}
                  </span>
                    </li>

                    <li>
                        <i class="fa fa-calendar-check-o bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time">{{ $appointment->search_id }}</span>

                            <h3 class="timeline-header">
                                <a href="#">Appointment</a>
                            </h3>
                        </div>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    @foreach($appointment->prescriptions as $prescription)
                        <li>
                            <i class="fa fa-file-text-o bg-blue"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $prescription->created_at->diffForHumans() }}</span>

                                <h3 class="timeline-header">
                                    <a href="#">Prescription</a>
                                </h3>

                                <div class="timeline-body">
                                    <p><strong>Drugs : </strong></p>
                                    @foreach($prescription->drugs as $drug)
                                        {{ $drug->type }} {{ $drug->name }} {{ $drug->strength }} | {{ $drug->dose }}
                                        | {{ $drug->advice }}
                                    @endforeach

                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Print</a>
                                    <a class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @foreach($appointment->payments as $payment)
                        <li>
                            <i class="fa fa-money bg-aqua"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $payment->created_at->diffForHumans() }}</span>

                                <h3 class="timeline-header"><a href="#">Payment</a></h3>

                                <div class="timeline-body">
                                    <dl>
                                        <dt>{{ $payment->payment_amount }}</dt>
                                        <dd>@if($payment->payment_type == 1)
                                                <td>Cash Payment</td>
                                            @elseif($payment->payment_type == 2)
                                                <td>Check Payment</td>
                                            @else
                                                <td>Card Payment</td>
                                            @endif | {{ $payment->payment_info }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @foreach($appointment->documents as $document)
                        <li>
                            <i class="fa fa-file-text bg-aqua"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $document->created_at->diffForHumans() }}</span>

                                <h3 class="timeline-header"><a href="#">Medical Document</a></h3>

                                <div class="timeline-body">
                                    <div class="row">
                                        @foreach($appointment->documents as $document)
                                            <div class="col-md-4">
                                                <a href="{{ showStorageImage($document->file) }}" target="_blank"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fa fa-expand" aria-hidden="true"></i>
                                                </a>
                                                <div class="document-block">
                                                    <iframe src="{{ showStorageImage($document->file) }}" height="250px"
                                                            frameborder="0"></iframe>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach

                    @foreach($appointment->notes as $note)
                        <li>
                            <i class="fa fa-commenting bg-aqua"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $document->created_at->diffForHumans() }}</span>

                                <h3 class="timeline-header"><a href="#">Note</a></h3>

                                <div class="timeline-body">
                                    <div class="row">
                                        @foreach($appointment->notes as $note)
                                            <div class="col-md-12 note-block">
                                                {!! $note->note !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </li>
                    @endforeach
                @endforeach
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div class="text-center" id="patientBlock">
                <img src="{{  asset($patient->photo ? $patient->photo : 'dash/img/avatar2.png') }}" alt="..."
                     class="img-circle">
                <h2>{{ $patient->title }} {{ $patient->full_name }}</h2>
                <p class="text-center">{{ $patient->occupation }} <br> {{ $patient->sex }}
                    <br> {{ $patient->age }}
                    <br> {{ $patient->cell_phone }} </p>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

