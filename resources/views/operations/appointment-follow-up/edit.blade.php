@extends('layouts.app')

@section('title')
    {{ __('appointment.create_followup_note') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.create_followup_note') }}</h3>
        </div>
        <form action="{{ route('follow-up-note.update',['id'=>encrypt($appointment_follow_up_note->id)]) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="appointment_id" value="{{ encrypt($appointment_follow_up_note->appointment->id) }}">
            <input type="hidden" id="plain_doctor" name="doctor_id" value="{{ $appointment_follow_up_note->appointment->doctor->id }}">
            <input type="hidden" id="encrypt_doctor" name="doctor_id" value="{{ encrypt($appointment_follow_up_note->appointment->doctor->id) }}">

            <div class="box-body">
                @include('operations.patient.patient-card-small',['appointment'=>$appointment_follow_up_note->appointment])
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">{{ __('appointment.form.select_date') }} <span class="text-danger">*</span></label>
                        <input required name="schedule_date" type="text" id="datepicker" class="form-control"
                               autocomplete="off"
                               placeholder="{{ __('appointment.form.select_date') }}"
                               value="{{ $appointment_follow_up_note->appointment->schedule_date }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('appointment.form.select_schedule_time') }} <span class="text-danger">*</span></label>
                        <select name="schedule_id" id="scheduleTime" class="form-control" required>
                            <option value="">{{ $appointment_follow_up_note->appointment->schedule_time }}</option>
                        </select>
                        <input type="hidden" name="schedule_time">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="">{{ __('appointment.create_followup_note') }}</label>
                        <textarea name="note" required cols="30" rows="10" class="form-control editor">{{ $appointment_follow_up_note->note }}</textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">{{ __('actions.submit') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
   
   <script>
        $(function () {
            $('.editor').wysihtml5({
                toolbar: {
                    image: false,
                    link: false
                },
                useLineBreaks: true
            });

            $.ajax({
                type: "get",
                url: "{{route('get.doctor')}}",
                data: {"doctor_id": $('#plain_doctor').val(),"video_consultation" : true},
                success: function(data) {
                    scheduleDays = data.scheduleDays;
                    var disableDate = [];
                    $('#datepicker').datepicker({
                        startDate: '1d',
                        autoclose: true,
                        format: 'dd-M-yyyy',
                        beforeShowDay: function(date){
                            if ($.inArray(date.getDay(), scheduleDays) == -1) {
                                if($.inArray(date.getDay(), disableDate) == -1){
                                    return false;
                                }
                            }
                        },
                    }).on('change', function () {
                        $.get('/get-schedule-by-dates/' + $(this).val() + '?doctor_id=' + $('#encrypt_doctor').val(), function (response) {
                            $('#scheduleTime').empty();
                            $('#scheduleTime').append(
                                $('<option>', {
                                    value: '',
                                    text: '{{ __('appointment.select_time') }}'
                                })
                            );
                            $.each(response.schedule_details, function (index, element) {
                                $('#scheduleTime').append(
                                    $('<option>', {
                                        value: element.id,
                                        text: element.start_time + ' To ' + element.end_time
                                    })
                                )
                            })

                        });
                    });

                },
                error:function(data)
                {
                    alert("Server error");
                }
            });
           

            $('#scheduleTime').on('change', function () {
                $('input[name=schedule_time]').val($(this).children("option:selected").text());
            })
        })
    </script>
@endsection

