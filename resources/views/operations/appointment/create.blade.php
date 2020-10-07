@extends('layouts.app')

@section('title')
    {{ __('appointment.create_appointment') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.create_appointment') }}</h3>
        </div>

        <form action="{{ route('appointment.store') }}" method="post" id="form">
            @csrf
            <div class="header animated fadeInLeft">
                <h2 class="header-title">{{ __('appointment.appointment') }} <span class="text-danger">*</span></h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('appointment.form.select_patient') }} <span class="text-danger">*</span> </label>
                            <select required name="patient_id" id="selectPatient" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('appointment.form.select_doctor') }} <span class="text-danger">*</span></label>
                            <select required name="doctor_id" id="doctor" class="form-control">
                                @if(auth()->user()->role == 2)
                                    <option value="{{ encrypt(auth()->user()->doctor->id) }}">{{ auth()->user()->doctor->title .' '. auth()->user()->doctor->full_name }}</option>
                                @else
                                    <option value="">{{ __('appointment.form.select_doctor') }}</option>
                                    @foreach(\App\Models\Department::all() as $department)
                                        <optgroup label="{{ $department->title }}">
                                            @foreach($department->doctors as $doctor)
                                                <option @if(request()->query('doctor'))  {{ decrypt(request()->query('doctor')) == $doctor->id ? 'selected' : '' }}  @endif  value="{{ encrypt($doctor->id) }}">{{ $doctor->title .' '. $doctor->full_name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach

                                @endif
                            </select>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">{{ __('appointment.form.select_date') }} <span class="text-danger">*</span></label>
                        <input required name="schedule_date" type="text" id="datepicker" class="form-control"
                               autocomplete="off"
                               placeholder="{{ __('appointment.form.select_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('appointment.form.select_schedule_time') }} <span class="text-danger">*</span></label>
                        <select name="schedule_id" id="scheduleTime" class="form-control" required>
                            <option value="">{{ __('appointment.form.select_schedule_time') }}</option>
                        </select>
                        <input type="hidden" name="schedule_time">
                    </div>
                </div>
            </div>

            <div class="box-body">
                <h2 class="header-title">{{ __('payment.title') }}</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">{{ __('payment.form.payment_amount') }}</label>
                        <input type="text" name="payment_amount" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('payment.form.payment_type') }}</label>
                            <select name="payment_type" id="" class="form-control">
                                <option value="1">khalti</option>
                                <option value="2">Esewa</option>
                                <option value="3">FonePay</option>
                                <option value="4">I-Pay</option>
                                <option value="5">Ime-Pay</option>
                                <option value="6">Bank</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <label for="">{{ __('payment.form.payment_description') }}</label>
                        <textarea name="payment_info" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="form-group">
                    <label for=""> {{ __('appointment.form.ref_appointment') }} </label>
                    <input name="ref_appointment" type="text" class="form-control"
                           value="{{ request()->query('appointment') }}">
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('actions.submit') }}</button>
                <button type="reset" class="btn btn-danger">{{ __('actions.reset') }}</button>
            </div>
        </form>

    </div>

@endsection

@section('js')
    <script src="{{ asset('dash/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('#datepicker').datepicker({
                startDate: '1d',
                autoclose: true,
                format: 'dd-M-yyyy'
            }).on('change', function () {
                $.get('/get-schedule-by-dates/' + $(this).val() + '?doctor_id=' + $('#doctor').val(), function (response) {
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

            $('#scheduleTime').on('change', function () {
                $('input[name=schedule_time]').val($(this).children("option:selected").text());
            })


            $("#selectPatient").select2({
                ajax: {
                    url: '/all-patient',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }
                        return query;
                    },
                    processResults: function (data) {
                        let formatedData = [];
                        data.data.forEach((element) => {
                            formatedData.push({
                                id: element.id,
                                text: element.full_name + ' | Mobile : ' + element.cell_phone
                            })
                        });
                        return {
                            results: formatedData
                        }
                    }
                }
            });

            // $("#doctor").select2();

            @if(request()->query('patient'))
            $.get('/get-patient/{{ request()->query('patient') }}', function (response) {
                var data = {
                    id: response.id,
                    text: response.full_name + ' | Mobile :' + response.cell_phone
                };

                var newOption = new Option(data.text, data.id, false, false);
                $('#selectPatient').append(newOption).trigger('change');
            });
            @endif


        })
    </script>
@endsection