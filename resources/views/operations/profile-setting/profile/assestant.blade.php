@extends('layouts.app')

@section('title')
    Assistant Profile
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/iCheck/all.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('assistant.edit_assistant') }}</h3>
        </div>

        <form action="{{ route('update.assistant.profile') }}" method="post" id="update_form" enctype="multipart/form-data">
            @csrf
            <div class="header animated fadeInLeft">
                <h2 class="header-title">{{ __('actions.personal_information') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <center>
                            <div id="image-preview" style="background-image: url('{{ auth()->user()->photo }}')">
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
                                    <input type="text" class="form-control" name="full_name"
                                           value="{{ auth()->user()->full_name }}"
                                           placeholder="{{ __('admin.full_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.user_name') }}</label>
                                    <input type="text" class="form-control" readonly
                                           value="{{ auth()->user()->user_name }}"
                                           placeholder="{{ __('actions.user_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.email') }} <span class="text text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" readonly
                                           value="{{ auth()->user()->email }}"
                                           placeholder="{{ __('actions.email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('actions.phone') }}</label>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{ auth()->user()->assistant->phone }}"
                                           placeholder="{{ __('actions.phone') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">{{ __('patient.address') }}</label>
                                    <textarea name="address" id="" cols="30" rows="5" class="form-control">{{ auth()->user()->assistant->address }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-offset-4 col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('actions.submit') }}</button>
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