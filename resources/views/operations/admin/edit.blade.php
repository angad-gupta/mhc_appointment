@extends('layouts.app')

@section('title')
    {{ __('admin.edit_admin') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/iCheck/all.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.edit_admin') }}</h3>
        </div>

        <form action="{{ route('admin.update',['id'=>encrypt($admin->id)]) }}" method="post" id="update_form"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="header animated fadeInLeft">
                <h2 class="header-title">{{ __('actions.personal_information') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <center>
                            <div id="image-preview" style="background-image: url('{{ asset($admin->photo ? $admin->photo : 'dash/img/boxed-bg.jpg') }}')">
                                <label for="" id="image-label">{{ __('admin.admin_photo') }}</label>
                                <input name="image" type="file" id="image-upload">
                            </div>
                        </center>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('admin.full_name') }} <span class="text text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="full_name" required
                                           value="{{ $admin->full_name }}"
                                           placeholder="{{ __('admin.full_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.user_name') }}</label>
                                    <input type="text" class="form-control" name="user_name"
                                           value="{{ $admin->user_name }}"
                                           placeholder="{{ __('actions.user_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.email') }} <span class="text text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ $admin->email }}"
                                           placeholder="{{ __('actions.email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.phone') }}</label>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{ $admin->phone }}"
                                           placeholder="{{ __('actions.phone') }}">
                                </div>
                            </div>
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
                                <label for="">{{ __('patient.address') }}</label>
                                <textarea name="address" id="" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" {{ $admin->status == 1 ? 'checked' : '' }}>
                                        {{ __('actions.active') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <button class="btn btn-primary">{{ __('actions.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/image-preview/jquery.imagePreview.js') }}"></script>
    <script src="{{ asset('dash/plugins/iCheck/icheck.min.js') }}"></script>

@endsection

