@extends('layouts.app')

@section('title')
    {{ __('patient.edit_patient') }}
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

    @include('documentation.patient.general_info')
    @include('documentation.patient.contact_info')

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('patient.edit_patient') }}  </h3>
        </div>


        <form action="{{ route('patient.update',['id'=>encrypt($patient->id)]) }}" method="post" id="update_form" enctype="multipart/form-data">
            @csrf
            @method('put')
        <!-- Patient general information -->
            <div class="header">
                <i class="fa fa-info-circle pull-right text-info" data-toggle="modal"
                   data-target="#general_information"></i>
                <h2 class="header-title">{{ __('patient.general_info') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <center>
                            <div id="image-preview" style="background-image: url('{{ $patient->photo ? asset($patient->photo) : '' }}')">
                                <label for="" id="image-label">{{ __('patient.patient_photo') }}</label>
                                <input name="image" type="file" id="image-upload">
                            </div>
                        </center>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('doctor.title') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="title" required class="form-control"
                                           value="{{ $patient->title }}"
                                           placeholder="{{ __('doctor.title') }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{ __('patient.name') }} <span class="text-danger">*</span> </label>
                                    <input type="text" name="full_name" required class="form-control"
                                           value="{{ $patient->full_name }}"
                                           placeholder="{{ __('patient.name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('doctor.sex') }} <span class="text-danger">*</span> </label>
                                    <select name="sex" class="form-control" required>
                                        <option {{ $patient->sex == 'Male' ? 'selected' : '' }} value="Male">Male
                                        </option>
                                        <option {{ $patient->sex == 'Female' ? 'selected' : '' }} value="Female">
                                            Female
                                        </option>
                                        <option {{ $patient->sex == 'Other' ? 'selected' : '' }} value="Other">Other
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.birth_date') }} <span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="date_of_birth" class="form-control" autocomplete="off"
                                           value="{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') }}"
                                           placeholder="YYYY-MM-DD" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{ __('patient.age') }}</label>

                                    <input type="text" name="age" value="{{ explode(" ", $patient->age)[0] }}" class="form-control" placeholder="Year">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{ __('patient.occupation') }}</label>
                                <input type="text" name="occupation" class="form-control"
                                       value="{{ $patient->occupation }}"
                                       placeholder="{{ __('patient.occupation') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('patient.height') }}</label>
                                <input type="text" name="height" class="form-control" value="{{ $patient->height }}"
                                       placeholder="{{ __('patient.height') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('patient.weight') }}</label>
                                <input type="text" name="weight" class="form-control" value="{{ $patient->weight }}"
                                       placeholder="{{ __('patient.weight') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Patient contact information -->
            <div class="header">
                <i class="fa fa-info-circle pull-right text-info" data-toggle="modal"
                   data-target="#contact_information"></i>
                <h2 class="header-title">{{ __('patient.contact_information') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.cell_phone') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="cell_phone" class="form-control" value="{{ $patient->cell_phone }}"
                                   placeholder="{{ __('patient.cell_phone') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.home_phone') }}</label>
                            <input type="text" name="home_phone" class="form-control" value="{{ $patient->home_phone }}"
                                   placeholder="{{__('patient.home_phone')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('patient.contact_email') }}</label>
                            <input type="email" name="contact_email" value="{{ $patient->contact_email }}"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('patient.country') }} <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control" value="{{ $patient->country }}"
                                   placeholder="{{ __('patient.country') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('patient.city') }} <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ $patient->city }}"
                                   placeholder="{{__('patient.city')}}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">{{ __('patient.address') }} <span class="text-danger">*</span></label>
                            <textarea required name="address" id="" cols="30" rows="5" class="form-control"
                                      placeholder="{{ __('patient.address') }}">{{ $patient->address }}</textarea>
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
                                   value="{{ $patient->user ? $patient->user->user_name : '' }}"
                                   placeholder="{{ __('actions.user_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('actions.email') }} </label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $patient->user != null ? $patient->user->email : '' }}"
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
            })

        })
    </script>
@endsection

