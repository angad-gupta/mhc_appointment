@extends('layouts.app')

@section('title') Doctor - Panel @endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    @php
        // dd(auth()->user()->doctor);
        $patient = \App\Models\DoctorsPatients::where('doctor_id', auth()->user()->doctor->id);
        $appointment = \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)->whereHas('payments');
        $payment = \App\Models\PatientPayment::where('doctor_id',auth()->user()->doctor->id);
        $prescription = \App\Models\Prescription::where('doctor_id',auth()->user()->doctor->id);
        $carbon = \Carbon\Carbon::now();
    @endphp
    
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green-gradient">
                <div class="inner">
                    <h3>{{ $appointment->whereBetween('created_at',[\Carbon\Carbon::now()->firstOfMonth()->toDateString(),\Carbon\Carbon::now()->lastOfMonth()->toDateString()])->count() }}</h3>

                    <p>{{ __('dashboard.common.widget.new_appointment') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('appointment.index') }}" class="small-box-footer"> {{ __('dashboard.common.more_info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-gradient">
                <div class="inner">
                    <h3>{{ $appointment->count() }}</h3>

                    <p>{{ __('dashboard.common.widget.total_appointment') }} </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('appointment.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner">
                    <h3>{{ $patient->whereBetween('created_at',[\Carbon\Carbon::now()->firstOfMonth()->toDateString(), \Carbon\Carbon::now()->lastOfMonth()->toDateString()])->count() }}</h3>

                    <p>{{ __('dashboard.common.widget.new_patient') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('patient.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon-gradient">
                <div class="inner">
                    <h3>{{ $patient->count() }}</h3>

                    <p>{{ __('dashboard.common.widget.total_patient') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('patient.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-black-gradient">
                <div class="inner">
                    <h3>{{ $prescription->count() }}</h3>

                    <p>{{ __('dashboard.common.widget.total_prescription') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('prescription.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-fuchsia-active">
                <div class="inner">

                    <h3>{{ $payment->sum('payment_amount') }}<sup style="font-size: 20px">({{ $payment->count() }}
                            )</sup></h3>

                    <p>{{ __('dashboard.common.widget.total_payment') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('patient-payment.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow-gradient">
                <div class="inner">
                    @php
                        $payment_monthly = $payment->whereBetween('created_at',[\Carbon\Carbon::now()->firstOfMonth()->toDateString(),\Carbon\Carbon::now()->lastOfMonth()->toDateString()]);
                    @endphp

                    <h3>{{$payment_monthly->sum('payment_amount') }} <sup
                                style="font-size: 20px">({{ $payment_monthly->count() }})</sup></h3>

                    <p>{{ __('dashboard.common.widget.payment_this_month') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('patient-payment.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red-gradient">
                <div class="inner">
                    @php
                        $payment_year = $payment->whereBetween('created_at',[\Carbon\Carbon::now()->firstOfYear()->toDateString(),\Carbon\Carbon::now()->lastOfYear()->toDateString()]);
                    @endphp
                    <h3>{{ $payment_year->sum('payment_amount') }} <sup
                                style="font-size: 20px">({{ $payment_year->count() }})</sup></h3>

                    <p>{{ __('dashboard.common.widget.payment_this_year') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('patient-payment.index') }}" class="small-box-footer">{{ __('dashboard.common.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('dashboard.tables.nearby_appointment.title') }}</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{ __('actions.serial') }}</th>
                    <th width="300px">{{ __('appointment.appointment') }}</th>
                    <th>{{ __('patient.patient') }}</th>
                    <th>{{ __('doctor.doctor') }}</th>
                    <th>{{ __('actions.status') }}</th>
                    <th width="200px"> {{ __('actions.actions') }}</th>
                </tr>
                </thead>

                <tbody>


                @forelse($appointment->whereBetween('schedule_date',[\Carbon\Carbon::now()->toDateString(), \Carbon\Carbon::now()->addDay(3)->toDateString()])->orderBy('schedule_date','asc')->get() as $key=>$ap)

                    <tr>
                        <td></td>
                        <td>
                            @include('operations.appointment.datatables.appointment-details',['appointment'=>$ap])
                        </td>
                        <td>
                            @include('operations.appointment.datatables.patient',['appointment'=>$ap])
                        </td>
                        <td>
                            @include('operations.appointment.datatables.doctor',['appointment'=>$ap])
                        </td>
                        <td>
                            @include('operations.appointment.datatables.status',['appointment'=>$ap])
                        </td>
                        <td>
                            @include('operations.appointment.datatables.action',['appointment'=>$ap])
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('dashboard.tables.nearby_follow_up.title') }}</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{ __('actions.serial') }}</th>
                    <th>{{ __('appointment.appointment') }}</th>
                    <th>{{ __('doctor.doctor') }}</th>
                    <th>{{ __('appointment.follow_up_date') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($appointment->whereBetween('next_followup',[\Carbon\Carbon::now()->toDateString(), \Carbon\Carbon::now()->addDay(3)->toDateString()])->orderBy('schedule_date','asc')->get() as $key=>$ap)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <a href="{{ route('appointment.show',['id'=> encrypt($ap->id)]) }}">{{ $ap->search_id }}</a>
                            <br>
                            <a href="{{ route('patient.show',['id'=>encrypt($ap->patient_id)]) }}">{{ $ap->patient->title }} {{ $ap->patient->full_name }}</a>
                            <br>
                            <button class="btn btn-xs btn-primary"><i class="fa fa-envelope-o"></i> Send follow up
                                mail
                            </button>

                            <hr>
                            <a href="{{ route('appointment.create','patient='.encrypt($ap->patient_id).'&doctor='.encrypt($ap->doctor_id).'&appointment='.$ap->search_id) }}">
                                <i class="fa fa-calendar-plus-o"></i> Create an appointment</a>
                        </td>
                        <td>
                            <a href="{{ route('doctor.show',['id'=>encrypt($ap->doctor_id)]) }}">{{ $ap->doctor->title }} {{ $ap->doctor->full_name }}</a>
                            <br>
                            {{ $ap->note }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($ap->next_followup)->format('l d-M-Y') }} <br>
                            <div class="row" style="padding: 0px 20px;">
                                @foreach($ap->followUpNotes as $n_key=>$note)
                                    <div class="col-md-12" style="border-bottom:1px solid gray; padding: 5px 0px;">
                                        {{ $n_key+1 }}. {{ str_limit(strip_tags($note->note), 150, '...') }}
                                        <div class="btn-group btn-group-xs pull-right">

                                            <button onclick="window.location.replace('{{ route('follow-up-note.edit',['id'=>encrypt($note->id)]) }}')"
                                                    class="btn btn-xs btn-success"><i class="fa fa-edit"></i>
                                            </button>
                                            <button onclick="$(this).confirmDelete($('#delete{{$note->id}}'))"
                                                    class="btn btn-xs btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            <form action="{{ route('follow-up-note.destroy',['id'=>encrypt($note->id)]) }}"
                                                  method="post" id="delete{{$note->id}}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </div>


                                @endforeach
                            </div>

                            <a href="{{ route('follow-up-note.create','appointment='.encrypt($ap->id)) }}">
                                <i class="fa fa-plus-circle"></i> Add follow up note</a>
                        </td>
                    </tr>

                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection

@section('js')
    <script src="{{ asset('dash/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(function () {
            $('table').DataTable({
                pageLength: 5,
            });
        })
    </script>
@endsection