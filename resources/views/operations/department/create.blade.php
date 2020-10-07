@extends('layouts.app')

@section('title')
    {{ __('department.create_department') }}
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
<link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
<link rel="stylesheet" href="{{ asset('dash/css/animate.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('department.create_department') }}</h3>
        </div>

        <form action="{{ route('department.store') }}" method="post" id="form">
            @csrf
            <div class="box-body">
              <div class="col-md-4">
                    <center>
                        <div id="image-preview">
                            <label for="" id="image-label">Department Image</label>
                            <input name="photo" type="file" id="image-upload">
                        </div>
                    </center>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="">{{ __('department.title') }} <span class="text-danger">*</span> </label>
                        <input required name="title" type="text" class="form-control"
                               placeholder="{{ __('department.department') }}">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('actions.submit') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/image-preview/jquery.imagePreview.js') }}"></script>
@endsection

