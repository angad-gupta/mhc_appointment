@extends('layouts.app')

@section('title')
    {{ $user->name }} - Details
@endsection

@section('css')

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('patient.view_patient') }} - {{ $user->name }} </h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="text-center">
                        <img src="{{  asset($user->photo ? $user->photo : 'dash/img/avatar2.png') }}" alt="..."
                             class="img-circle">
                        <h2>{{ $user->name }}</h2>
                        <p class="text-center"> {{ $user->gender }}
                            <br> {{ $user->getAgeAttribute() }}
                            <br> {{ $user->phone }} </p>
                    </div>

                    <hr>
                    <h4 class="text-center">{{ __('patient.contact_information') }}</h4>
                    <dl class="dl-horizontal">
                        <dt>{{ __('patient.contact_email') }}</dt>
                        <dd>
                            @if ($user->email)
                                {{ $user->email }}
                            @else
                                N/A
                            @endif
                        </dd>
                        <dt>{{ __('patient.cell_phone') }}</dt>
                        <dd>
                            @if ($user->phone)
                                {{ $user->phone }}
                            @else
                                N/A
                            @endif
                        </dd>
                        <dt>{{ __('patient.home_phone') }}</dt>
                        <dd>
                            @if ($user->phone)
                                {{ $user->phone }}
                            @else
                                N/A
                            @endif
                        </dd>
                        <dt>{{ __('patient.address') }}</dt>
                        <dd>
                            @if ($user->address)
                                {{ $user->address }}
                            @else
                                N/A
                            @endif
                        </dd>
                        <dt>{{ __('patient.city') }}</dt>
                        <dd>
                            @if ($user->city)
                                {{ $user->city }}
                            @else
                                N/A
                            @endif
                        </dd>
                        {{-- <dt>{{ __('patient.country') }}</dt>
                        <dd>
                            @if ($patient->country)
                                {{ $patient->country }}
                            @else
                                N/A
                            @endif
                        </dd> --}}
                    </dl>
                    <hr>
                    <h4 class="text-center">Appointment Details</h4>
                    <dl class="dl-horizontal">
                        <dt>{{ __('mail.invoice.total') }} {{ __('appointment.appointment') }}</dt>
                        <dd>
                            {{ $patient->appointments->count() }}
                            | {{ $patient->appointments->where('status',0)->count() }} {{ __('appointment.status.cancel') }}
                            | {{ $patient->appointments->where('status',1)->count() }} {{ __('appointment.status.pending') }}
                            | {{ $patient->appointments->where('status',2)->count() }} {{ __('appointment.status.complete') }}
                            | {{ $patient->appointments->where('status',4)->count() }} {{ __('appointment.status.on_process') }}
                            | <a href="{{ route('appointment.create','patient='.encrypt($patient->id)) }}"><i class="fa fa-plus"></i> {{ __('appointment.create_appointment') }} </a>
                        </dd>
                        <dt>{{ __('mail.invoice.total') }} {{ __('prescription.prescription') }}</dt>
                        <dd>{{ $patient->prescriptions->count() }}</dd>
                        <dt>{{ __('mail.invoice.total') }} {{ __('document.document') }}</dt>
                        <dd>{{ $patient->medicalDocuments->count() }}</dd>
                        <dt>{{ __('mail.invoice.total') }} {{ __('note.note') }}</dt>
                        <dd>{{ $patient->medicalNotes->count() }}</dd>
                        <dt>{{ __('mail.invoice.total') }} {{ __('payment.title') }}</dt>
                        <dd>{{ $patient->payments->sum('payment_amount') }} - {{ $patient->payments->count() }} Times</dd>
                    </dl>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="box-footer">


        </div>
    </div>
@endsection

@section('js')

@endsection

