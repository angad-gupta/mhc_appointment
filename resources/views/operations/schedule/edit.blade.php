@extends('layouts.app')

@section('title')
    {{ __('schedule.edit_schedule') }}
@endsection

@section('css')
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('dash/plugins/timepicker/bootstrap-timepicker.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('schedule.edit_schedule') }}</h3>
        </div>
        <form action="{{ route('edit-schedule',['id'=>encrypt($schedule_details->id)]) }}" method="post"
              id="update_form">
            @csrf
            @method('put')
            <input type="hidden" value="{{ encrypt($schedule_details->schedule->id) }}" name="schedule_id">
            <div class="box-body">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">{{ __('schedule.day') }} <span class="text-danger">*</span> </label>
                        <input type="text" readonly
                               value="{{ __('calender.days.'.$schedule_details->schedule->day_index) }}"
                               class="form-control" required placeholder="{{ __('schedule.day') }}">
                    </div>
                </div>
                <div class="col-md-4 bootstrap-timepicker">
                    <div class="form-group">
                        <label for="">{{ __('schedule.start_time') }} <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <input type="text" autocomplete="off" name="start_time" class="form-control timepicker"
                                   required placeholder="{{ __('schedule.start_time') }}" value="{{ $schedule_details->start_time }}">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 bootstrap-timepicker">
                    <div class="form-group">
                        <label for="">{{ __('schedule.end_time') }} <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <input type="text" autocomplete="off" name="end_time" class="form-control timepicker"
                                   required placeholder="{{ __('schedule.end_time') }}" value="{{ $schedule_details->end_time }}">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
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
    <script src="{{ asset('dash/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>
@endsection