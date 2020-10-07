@extends('layouts.app')

@section('title')
    {{ __('prescription.create_prescription') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/css/prescription.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')


    <div class="box box-primary presription">


        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription.create_prescription') }}</h3>
        </div>


        <div class="box-body">
        @if($appointment->appointment_type == 'video')
        <div class="row">
            <div class="col text-right">
             <div class="alert alert-primary" role="alert">
                <strong>Video call room created</strong>
                <br>
                 <a type="button" target="_blank" style="text-decoration:none;" href="{{route('join.doctor_room',$appointment->search_id)}}" class="btn btn-danger">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    Join Room
                </a>
                </div>
            </div>
          
        </div>
     
        @endif
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" id="mainTabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">{{ __('prescription.prescription') }}</a></li>
                    <li><a href="#tab_2" data-toggle="tab">{{ __('document.document') }}</a></li>
                    <li><a href="#tab_3" data-toggle="tab">{{ __('note.note') }}</a></li>
                    <li><a href="#payment" data-toggle="tab">{{ __('payment.title') }}</a></li>
                    <li><a href="#tab_4" data-toggle="tab">{{ __('patient.patient') }}</a></li>
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        {{--@include('operations.prescription.partials.prescription')--}}
                        <div id="app">
                            <prescription-component :appointment_id="{{ $appointment->id }}"
                                                    :patient_id="{{ $appointment->patient_id }}"
                                                    :doctor_id="{{ $appointment->doctor_id }}"></prescription-component>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        @include('operations.prescription.partials.medical-file')
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        @include('operations.prescription.partials.note')
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_4">
                        @include('operations.prescription.partials.patient')
                    </div>
                    <!-- /.tab-pane -->
                    <div id="payment" class="tab-pane">
                        @include('operations.prescription.partials.payment')
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <div class="box-footer">

            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#finishAppointment">
                <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                {{ __('appointment.finish_appointment') }}
            </button>
            @include('operations.appointment.finish-appointment')
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('.html-editor').wysihtml5();


            var hash = window.location.hash;
            if (hash != '') {
                $('#mainTabs a[href="' + hash + '"]').tab('show');
                $('.nav-tabs li').removeClass('active');
                $('.nav-tabs li a').each(function (index,value) {
                    if(value.hash == hash){
                        value.parentNode.className = 'active';

                    }
                })
            }

            $('.datepicker').datepicker({
                startDate: '1d',
                autoclose: true,
                format: 'dd-M-yyyy',
            })

        });

        function openPopUp(src) {
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
            window.open(src, 'Open', params);
        }

    </script>
@endsection
