@extends('layouts.app')

@section('title')
    {{ __('patient.create_patient') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
    <link rel="stylesheet"
          href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <style>
        .datepicker {
            z-index: 1100 !important;
        }
    </style>
@endsection

@section('content')

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('patient.create_patient') }}  </h3>
        </div>


        <form action="{{ route('patient.store') }}" method="post" id="savePatient" enctype="multipart/form-data">
        @csrf
        <!-- Patient general information -->
            <div class="header">
                <h2 class="header-title">{{ __('patient.general_info') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <center>
                            <div id="image-preview">
                                <label for="" id="image-label">{{ __('patient.patient_photo') }}</label>
                                <input name="image" type="file" id="image-upload">
                            </div>
                        </center>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.title') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="title" required class="form-control"
                                           placeholder="{{ __('doctor.title') }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{ __('patient.name') }} <span class="text-danger">*</span> </label>
                                    <input type="text" name="full_name" required class="form-control"
                                           placeholder="{{ __('patient.name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.sex') }} <span class="text-danger">*</span> </label>
                                    <select name="sex" class="form-control" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.birth_date') }} <span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="date_of_birth" class="form-control" autocomplete="off"
                                           placeholder="YYYY-MM-DD" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.age') }}</label>
                                    <input type="number" name="age" class="form-control" placeholder="Year">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{ __('patient.occupation') }}</label>
                                <input type="text" name="occupation" class="form-control"
                                       placeholder="{{ __('patient.occupation') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('patient.height') }}</label>
                                <input type="text" name="height" class="form-control"
                                       placeholder="{{ __('patient.height') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('patient.weight') }}</label>
                                <input type="text" name="weight" class="form-control"
                                       placeholder="{{ __('patient.weight') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Patient contact information -->
            <div class="header">

                <h2 class="header-title">{{ __('patient.contact_information') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.cell_phone') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="cell_phone" class="form-control"
                                   placeholder="{{ __('patient.cell_phone') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.home_phone') }}</label>
                            <input type="text" name="home_phone" class="form-control"
                                   placeholder="{{__('patient.home_phone')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.contact_email') }}</label>
                            <input type="email" name="contact_email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('patient.country') }}</label>
                            <input type="text" name="country" class="form-control"
                                   placeholder="{{ __('patient.country') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('patient.city') }}</label>
                            <input type="text" name="city" class="form-control" placeholder="{{__('patient.city')}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">{{ __('patient.address') }} <span class="text-danger">*</span></label>
                            <textarea required name="address" id="" cols="30" rows="5" class="form-control"
                                      placeholder="{{ __('patient.address') }}"></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Patient account information -->
            <div class="header">
                <h2 class="header-title">{{ __('actions.account_information') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('actions.user_name') }} </label>
                            <input type="text" name="user_name" class="form-control"
                                   placeholder="{{ __('actions.user_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('actions.email') }} </label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="{{ __('actions.email') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('actions.password') }}  </label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="{{ __('actions.password') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('actions.re_type_password') }} </label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="{{ __('actions.re_type_password') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-block btn-lg">{{ __('actions.submit') }}</button>
            </div>
        </form>
    </div>

    <form action="{{ route('quick.appointment') }}" id="quickAppointment" method="post">
        @csrf
        <input type="hidden" value="" id="encryptedPatientId" name="patient_id">
    </form>

@endsection

@section('js')
    <script src="{{ asset('dash/plugins/image-preview/jquery.imagePreview.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5();
            let date_of_birth = $("input[name=date_of_birth]");
            let age = $("input[name=age]");
            date_of_birth.datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            date_of_birth.on('changeDate', function () {
                var duration = moment.duration(moment().diff(moment($(this).val())));
                $("input[name=age]").val(duration.asYears());
            });

            $("input[name=age]").on('input', function (e) {
                e.preventDefault();
                var data = moment();
                date_of_birth.val(data.subtract($(this).val(), 'years').format('YYYY-MM-DD'));
            });

            $("#savePatient").on('submit', function (e) {
                e.preventDefault();
                $(this).showLoader(true);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $(this).showLoader(false);
                        $("#encryptedPatientId").val(data.encrypted_id);
                        swal({
                            title: 'Patient saved',
                            text: 'What do you want to do now',
                            icon: 'success',
                            buttons: {
                                appointment: "Create Appointment",
                                @doctor
                                quickAppointment: "Quick Appointment",
                                @enddoctor
                                close: 'Close'
                            }
                        }).then((value) => {
                            switch (value) {
                                case "appointment" :
                                    window.location.replace('{{ route('appointment.create','patient=') }}' + data.encrypted_id);
                                    break;
                                case "quickAppointment":
                                    $("#quickAppointment").submit();
                                    break;
                            }
                        })
                    },
                    error: function (data) {
                        $(this).showLoader(false);
                        if (data.status === 422) {
                            $(this).showValidationError(data);
                        } else if (data.status === 421) {
                            toastr.error(data.responseJSON[0], data.responseJSON[1]);
                        } else {
                            toastr.error(data.responseJSON.message);
                        }
                    }
                });
            })

        })
    </script>
@endsection

