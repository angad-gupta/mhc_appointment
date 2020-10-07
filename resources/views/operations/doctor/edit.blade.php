@extends('layouts.app')

@section('title')
{{ __('doctor.create_doctor') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
<link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
<link rel="stylesheet" href="{{ asset('dash/css/animate.css') }}">
@endsection

@section('content')
<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">{{ __('doctor.edit_doctor') }}</h3>
    </div>


    <form action="{{ route('doctor.update',['id'=>encrypt($doctor->id)]) }}" method="post" id="update_form"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="header animated fadeInLeft">
            <h2 class="header-title">{{ __('actions.personal_information') }}</h2>
        </div>
        <div class="box-body">
            <div class="row animated fadeInLeft delay-800ms">
                <div class="col-md-4">
                    <center>
                        <div id="image-preview"
                            style="background-image: url('{{ $doctor->photo ? asset($doctor->photo) : '' }}')">
                            <label for="" id="image-label">{{ __('doctor.doctor_photo') }}</label>
                            <input name="image" type="file" id="image-upload">
                        </div>
                    </center>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">{{ __('doctor.title') }} <span class="text-danger">*</span> </label>
                                <input type="text" name="title" class="form-control" value="{{ $doctor->title }}"
                                    placeholder="{{ __('doctor.title') }}" required>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="">{{ __('doctor.full_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="full_name" class="form-control"
                                    value="{{ $doctor->full_name }}" placeholder="{{ __('doctor.full_name') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">{{ __('doctor.sex') }} <span class="text-danger">*</span> </label>
                                <select name="sex" class="form-control" required>
                                    <option {{ $doctor->sex == 'Male' ? 'selected' : '' }} value="Male">Male
                                    </option>
                                    <option {{ $doctor->sex == 'Female' ? 'selected' : '' }} value="Female">Female
                                    </option>
                                    <option {{ $doctor->sex == 'Other' ? 'selected' : '' }} value="Other">Other
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">{{ __('department.department') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select name="department_id" class="form-control" required>
                                        <option value="">{{ __('actions.select') }} {{ __('department.department') }}
                                        </option>
                                        @foreach($departments as $department)
                                        <option {{ $doctor->department_id == $department->id ? 'selected' : '' }}
                                            value="{{ $department->id }}">{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <a class="btn btn-default" href="{{ route('department.create') }}"><i
                                                class="fa fa-plus"></i></a>
                                    </span>
                                </div>

                            </div><!-- /input-group -->


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Services</label>
                                <input type="text" name="services" class="form-control" placeholder="Services">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Location
                                </label>
                                <input type="text" name="location" class="form-control" placeholder="Location">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience">Expereince (In Years)</label>
                                <input type="number" name="experience" value="{{$doctor->experience}}" class="form-control" placeholder="5">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_status">Doctor Status</label>
                                <select class="form-control" name="doctor_status">
                                    <option disabled selected>Choose Status</option>
                                    <option {{$doctor->doctor_status == 'approved' ? 'selected' : '' }} value="approved">Approved</option>
                                    <option {{$doctor->doctor_status == 'rejected' ? 'selected' : '' }} value="rejected">Rejected</option>
                                    <option {{$doctor->doctor_status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">NMC Number</label>
                                <input class="form-control" type="text" name="nmc_number"
                                    value="{{$doctor->nmc_number}}" placeholder="NMC Number" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="video_consultation_fee">Video Consultation Fee Amount</label>
                                <input class="form-control" type="number" id="video_consultation_fee"
                                    name="video_consultation_fee" value="{{$doctor->video_consultation_fee}}" placeholder="Video Consultation Fee amount in Rs" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="normal_consultation_fee">Consultation Fee Amount</label>
                                <input class="form-control" type="number" id="normal_consultation_fee"
                                    name="normal_consultation_fee" value="{{$doctor->normal_consultation_fee}}" placeholder="Consultation Fee amount in Rs" />
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{ __('doctor.info') }}</label>
                                <textarea class="form-control" name="info" placeholder="{{ __('doctor.info') }}"
                                    cols="10" rows="3">{{ $doctor->info }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row animated fadeInLeft">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{ __('doctor.description') }}</label>
                        <textarea class="textarea"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                            name="descriptions" rows="10">{{ $doctor->descriptions }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row animated fadeInLeft">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Qualification</label>
                        <textarea class="textarea"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                            name="qualification" rows="10">{{ $doctor->qualification }}</textarea>
                    </div>
                </div>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="featured" {{ $doctor->featured ? 'checked' : '' }}>
                    Featured ! Will show in main page
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="video_consultation"
                        {{ $doctor->video_consultation == 1 ? 'checked' : '' }}>
                    Video Consultation available?
                </label>
            </div>
        </div>
        <div class="header animated fadeInDown">
            <h2 class="header-title">{{ __('actions.account_information') }}</h2>
        </div>
        <div class="box-body animated fadeInUp">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('actions.user_name') }} </label>
                        <input type="text" name="user_name" value="{{ $doctor->user->user_name }}" class="form-control"
                            placeholder="{{ __('actions.user_name') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('actions.email') }} <span class="text-danger">*</span> </label>
                        <input type="email" name="email" class="form-control" value="{{ $doctor->user->email }}"
                            placeholder="{{ __('actions.email') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('actions.password') }} </label>
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
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="status" {{ $doctor->user->status == 1 ? 'checked' : '' }}>
                            {{ __('actions.active') }}
                        </label>
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
<script>
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5();
    })
</script>
@endsection