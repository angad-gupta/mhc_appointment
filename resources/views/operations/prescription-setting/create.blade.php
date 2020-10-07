@extends('layouts.app')

@section('title')
    Prescription Setting
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary presription">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription-setting.prescription_setting') }}</h3>
        </div>

        @if(auth()->user()->role == 2)
            <form action="{{ route('prescription-settings.store') }}" method="post">
                @else
                    <form action="{{ route('prescription-settings.store') }}" method="post" id="form">
                        @endif
                        @csrf

                        <div class="box-body">
                            @if(auth()->user()->role == 2)
                                <input type="hidden" name="doctor_id" value="{{ encrypt(auth()->user()->doctor->id) }}">
                            @else
                                <div class="form-group">
                                    <label for="">{{ __('doctor.select_doctor') }}</label>
                                    <select name="doctor_id" required class="form-control">
                                        <option value="">Select Doctor</option>
                                        @foreach(\App\Models\Doctor::all() as $doctor)
                                            <option value="{{ encrypt($doctor->id) }}">{{ $doctor->title }} {{ $doctor->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input name="show_top_left" type="checkbox" id="topLeft">
                                                <label for="topLeft">{{ __('prescription-setting.form.show_top_left') }}</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('prescription-setting.form.top_left_text') }}</label>
                                                <textarea name="top_left" id="" cols="30" rows="10" class="form-control editor"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input name="show_top_right" type="checkbox" id="topRight">
                                                <label for="topRight">{{ __('prescription-setting.form.show_top_right') }}</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('prescription-setting.form.top_right_text') }}</label>
                                                <textarea name="top_right" id="" cols="30" rows="10" class="form-control editor"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-flat">{{ __('actions.submit') }}</button>
                        </div>
                    </form>


    </div>

@endsection

@section('js')
    <script src="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>
        $(function () {
            $('.editor').wysihtml5({
                toolbar: {
                    image: false,
                    link: false
                },
                useLineBreaks: true
            });
        })
    </script>
@endsection

