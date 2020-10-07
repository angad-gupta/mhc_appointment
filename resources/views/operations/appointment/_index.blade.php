@extends('layouts.app')

@section('title')
    {{ __('appointment.all_appointment') }}
@endsection

@section('css')
    <link rel="stylesheet"
          href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.all_appointment') }}</h3>
        </div>
        <div class="box-body">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ request()->query('status') == 1 ? 'active' : '' }}"><a class="text-warning"
                                                                                         href="{{ route('appointment.index').'?status=1' }}"><i
                                    class="fa fa-hourglass-half " aria-hidden="true"></i> <strong
                                    class="hidden-xs">Pending</strong></a></li>
                    <li class="{{ request()->query('status') == 2 ? 'active' : '' }}"><a class="text-success"
                                                                                         href="{{ route('appointment.index').'?status=2' }}"><i
                                    class="fa fa-check-circle-o" aria-hidden="true"></i> <strong class="hidden-xs">Completed</strong></a>
                    </li>
                    <li class="{{ request()->query('status') == 0 ? 'active' : '' }}"><a class="text-danger"
                                                                                         href="{{ route('appointment.index').'?status=0' }}"><i
                                    class="fa fa-ban" aria-hidden="true"></i> <strong
                                    class="hidden-xs">Canceled</strong></a>
                    </li>
                    <li class="{{ request()->query('status') == 4 ? 'active' : '' }}"><a class="text-info"
                                                                                         href="{{ route('appointment.index').'?status=4' }}"><i
                                    class="fa fa-refresh fa-spin" aria-hidden="true"></i> <span class="hidden-xs">{{ $pending_appointments }} On Process</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active table-responsive" id="tab_1">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Appointment ID</th>
                                <th>Patient ID</th>
                                <th>Doctor ID</th>
                                <th>Appointment Type</th>
                                <th>Appointment Date & Time</th>
                                <th>Created By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $key=>$appointment)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ $appointment->patient->title }} {{ $appointment->patient->full_name }}</td>
                                    <td>{{ $appointment->doctor->title }} {{ $appointment->doctor->full_name }}</td>
                                    <td>{{$appointment->appointment_type == 'clinic' ? 'Normal' : 'Video Consultation'}}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->schedule_date)->format('l d-m-Y') }},
                                        <br> {{ $appointment->schedule_time }}</td>
                                    <td>{{ $appointment->createdBy->user_name }}</td>

                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                            @if($appointment->status == 1)
                                                <button class="btn btn-default"
                                                        onclick="document.getElementById('startAppointment{{$key}}').submit()">
                                                    <i class="fa fa-play"></i>
                                                </button>
                                                <form action="{{ route('start.appointment') }}"
                                                      id="startAppointment{{$key}}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ encrypt($appointment->id) }}"
                                                           name="appointment_id">
                                                </form>
                                            @endif
                                            <a href="{{ route('appointment.show',['id'=>encrypt($appointment->id)]) }}"
                                               class="btn btn-default"><i class="fa fa-eye"></i></a>
                                            <button type="button" class="btn btn-default">
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-default">
                                                <i class="fa fa-folder-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-default">
                                                <i class="fa fa-files-o" aria-hidden="true"></i>
                                            </button>
                                            @if($appointment->status != 4)

                                                <a href="{{ route('appointment.edit',['id'=>encrypt($appointment->id)]) }}"
                                                   class="btn btn-default">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>

                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>


                                        @if(request()->query('status') == 4)
                                            <hr>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                                <button type="button"
                                                        onclick="document.getElementById('quickAppointment{{$key}}').submit()"
                                                        class="btn btn-success"
                                                        title="Resume Appointment">
                                                    <i class="fa fa-play" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#finishAppointment">
                                                    <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                                                    Finish Appointment
                                                </button>

                                                @include('operations.appointment.finish-appointment')

                                                <form action="{{ route('quick.appointment') }}"
                                                      id="quickAppointment{{$key}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="patient_id"
                                                           value="{{ encrypt($appointment->patient_id) }}">
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $appointments->links() }}
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-M-yyyy',
            })
        })
    </script>
@endsection