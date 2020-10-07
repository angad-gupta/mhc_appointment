@extends('layouts.app')

@section('title')
    {{ __('appointment.follow_up') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.follow_up') }}</h3>
        </div>

        <div class="box-body">

            <form action="" class="row">
                <div class="col-md-2">
                    <label for="">{{ __('appointment.appointment') }} {{ __('actions.serial') }}</label>
                    <input type="text" name="appointment_id" value="{{ request()->query('appointment_id') }}"
                           placeholder="{{ __('appointment.appointment_id') }}"
                           class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">{{ __('patient.patient') }}</label>
                    <select name="patient" id="selectPatient" class="form-control">
                        <option value="dd">{{ __('patient.patient') }}</option>
                    </select>
                </div>
                @doctor
                @else
                    <div class="col-md-3">
                        <label for=""> {{ __('doctor.doctor') }} </label>
                        <select name="doctor" class="form-control select2">
                            <option value="">{{ __('doctor.doctor') }}</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @enddoctor
                    <div class="col-md-3">
                        <label for="">{{ __('appointment.form.date_range') }}</label>
                        <input type="text" name="date_range"
                               class="form-control date-range"
                               value="{{ $request->query('date_range') }}"
                               placeholder="{{ __('appointment.form.date_range') }}"
                               autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <label for="">{{ __('actions.sort_by') }}</label>
                        <select name="sort_by" class="form-control">
                            <option {{ setSelectOption(request()->query('sort_by'),'asc') }} value="asc">A-Z
                            </option>
                            <option {{ setSelectOption(request()->query('sort_by'),'desc') }} value="desc">Z-A
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for=""></label>
                        <button type="submit" class="btn btn-success btn-block">{{ __('actions.filter') }}</button>
                        <a href="{{ route('report.follow-up','appointment_id='.request()->query('appointment_id').'&patient='.request()->query('patient').'&doctor='.request()->query('doctor').'&date_range='.request()->query('date_range').'&sort_by='.request()->query('sort_by')) }}">{{ __('actions.download_pdf') }}</a>
                    </div>
            </form>
            <br>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <form method="get">
                        <tr>
                            <th>{{ __('actions.serial') }}</th>
                            <th>{{ __('appointment.appointment') }}</th>

                            <th>
                                {{ __('doctor.doctor') }}
                            </th>
                            <th>
                                {{ __('appointment.follow_up_date') }}
                            </th>
                        </tr>
                    </form>
                    </thead>
                    <tbody>
                    @foreach($appointments as $key=>$appointment)
                        <tr>
                            <td>{{ $appointments->firstItem() + $key }}</td>
                            <td>
                                <a href="{{ route('appointment.show',['id'=> encrypt($appointment->id)]) }}">{{ $appointment->search_id }}</a>
                                <br>
                                <a href="{{ route('patient.show',['id'=>encrypt($appointment->patient_id)]) }}">{{ $appointment->patient->title }} {{ $appointment->patient->full_name }}</a>
                                <br>
                                <button class="btn btn-xs btn-primary" data-toggle="modal"
                                        data-target="#myModal{{$key}}">
                                    <i class="fa fa-envelope-o"></i> Send follow up mail
                                </button>

                                <div class="modal fade" id="myModal{{$key}}" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel"> Follow up mail</h4>
                                            </div>
                                            <form action="{{ route('mail.follow-up') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="appointment_id"
                                                       value="{{ encrypt($appointment->id) }}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">{{ __('actions.email') }}</label>
                                                        <input type="email" name="email"
                                                               value="{{ $appointment->patient->contact_email }}"
                                                               required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""> Follow up Note</label>
                                                        <textarea name="follow_up_note" cols="30" rows="3"
                                                                  class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        {{ __('actions.cancel') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">{{ __('mailbox.send_mail') }}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <a href="{{ route('appointment.create','patient='.encrypt($appointment->patient_id).'&doctor='.encrypt($appointment->doctor_id).'&appointment='.$appointment->search_id) }}">
                                    <i class="fa fa-calendar-plus-o"></i> {{ __('appointment.create_appointment') }}</a>
                            </td>
                            <td>
                                <a href="{{ route('doctor.show',['id'=>encrypt($appointment->doctor_id)]) }}">{{ $appointment->doctor->title }} {{ $appointment->doctor->full_name }}</a>
                                <br>
                                {{ $appointment->note }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->next_followup)->format('l d-M-Y') }} <br>
                                <div class="row" style="padding: 0px 20px;">
                                    @foreach($appointment->followUpNotes as $n_key=>$note)
                                        <div class="col-md-12" style="border-bottom:1px solid gray; padding: 5px 0px;">
                                            {{ $n_key+1 }}. {{ str_limit(strip_tags($note->note), 150, '...') }}
                                            <div class="btn-group btn-group-xs pull-right">

                                                <button onclick="window.location.replace('{{ route('follow-up-note.edit',['id'=>encrypt($note->id)]) }}')"
                                                        class="btn btn-xs btn-success"><i class="fa fa-edit"></i>
                                                </button>
                                                <button onclick="$(this).confirmDelete($('#delete{{$note->id}}'))"
                                                        class="btn btn-xs btn-danger"><i
                                                            class="fa fa-trash"></i></button>
                                                <form action="{{ route('follow-up-note.destroy',['id'=>encrypt($note->id)]) }}"
                                                      method="post" id="delete{{$note->id}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </div>


                                    @endforeach
                                </div>

                                <a href="{{ route('follow-up-note.create','appointment='.encrypt($appointment->id)) }}">
                                    <i class="fa fa-plus-circle"></i> {{ __('appointment.create_followup_note') }}</a>
                            </td>
                        </tr>


                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            {{ $appointments->links() }}
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(function () {
            $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="date_range"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
            });

            $('input[name="date_range"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $('.select2').select2();

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
                        let formatedData = [{id: 'dd', text: 'Select Patient'}];
                        data.data.forEach((element) => {
                            formatedData.push({
                                id: element.id,
                                text: element.full_name + ' | Mobile : ' + element.cell_phone
                            })
                        });
                        return {
                            results: formatedData
                        }
                        // console.log(data);
                    }
                }
            });
        })
    </script>
@endsection