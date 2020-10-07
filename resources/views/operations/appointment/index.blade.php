@extends('layouts.app')

@section('title')
    {{ __('appointment.all_appointment') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">


@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.all_appointment') }}</h3>
        </div>
        <div class="box-body">

            <form action="" class="row" method="get">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for=""> {{ __('appointment.appointment') }} </label>
                        <input name="appointment_id"
                               value="{{ $request->query('appointment_id') }}"
                               type="text" autocomplete="off"
                               class="form-control" placeholder="{{ __('appointment.appointment_id') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">{{ __('appointment.form.date_range') }}</label>
                        <input name="date_range"
                               type="text"
                               class="form-control date-range"
                               autocomplete="off"
                               value="{{ $request->query('date_range') }}"
                               placeholder="{{ __('appointment.form.date_range') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">{{ __('appointment.form.select_patient') }}</label>
                        <select name="patient" id="selectPatient" class="form-control">
                            <option value="">{{ __('appointment.form.select_patient') }}</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @doctor

                @else
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">{{ __('appointment.form.select_doctor') }}</label>
                            <select name="doctor" id="" class="form-control select2">
                                <option value="dd">{{ __('appointment.form.select_doctor') }}</option>
                                @foreach(\App\Models\Doctor::all() as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->title }} {{ $doctor->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @enddoctor

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">{{ __('actions.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="">Select</option>
                                <option {{ $request->query('status') == '0' ? 'selected' : '' }} value="0">
                                    {{ __('appointment.status.cancel') }}
                                </option>
                                <option {{ $request->query('status') == 1 ? 'selected' : '' }} value="1">{{ __('appointment.status.pending') }}
                                </option>
                                <option {{ $request->query('status') == 2 ? 'selected' : '' }} value="2">{{ __('appointment.status.complete') }}
                                </option>
                                <option {{ $request->query('status') == 3 ? 'selected' : '' }} value="3">{{ __('appointment.status.confirm') }}
                                </option>
                                <option {{ $request->query('status') == 4 ? 'selected' : '' }} value="4">
                                    {{ __('appointment.status.on_process') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for=""> {{ __('actions.sort_by') }} </label>
                            <select name="sort_by" class="form-control">
                                <option {{ setSelectOption(request()->query('sort_by'),'asc') }} value="asc">A-Z
                                </option>
                                <option {{ setSelectOption(request()->query('sort_by'),'desc') }} value="desc">Z-A
                                </option>
                            </select></div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-flat btn-block"><i
                                    class="fa fa-sliders"></i> &nbsp; {{ __('actions.filter') }}
                        </button>
                        <a target="_blank"
                           href="{{ route('report.appointment','date_range='.request()->query('date_range').'&patient='.request()->query('patient').'&doctor='.request()->query('doctor').'&status='.request()->query('status').'&sort_by='.request()->query('sort_by')) }}">{{ __('actions.download_pdf') }}</a>

                    </div>

            </form>

            <hr>


            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="ajaxDatatable">
                    <thead>
                    <tr>
                        <th>{{ __('actions.serial') }}</th>
                        <th>{{ __('appointment.appointment') }}</th>
                        <th>{{ __('patient.patient') }}</th>
                        <th>{{ __('doctor.doctor') }}</th>
                        <th>Appointment type</th>
                        <th width="150px">{{ __('actions.status') }}</th>
                        <th width="200px">{{ __('actions.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($appointments as $key=>$appointment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @include('operations.appointment.datatables.appointment-details',['appointment'=>$appointment])
                            </td>
                            <td>
                                @include('operations.appointment.datatables.patient',['appointment'=>$appointment])
                            </td>
                            <td>
                                @include('operations.appointment.datatables.doctor',['appointment'=>$appointment])
                            </td>
                             <td>{{$appointment->appointment_type == 'clinic' ? 'Normal' : 'Video Consultation'}}</td>
                            <td>
                                @include('operations.appointment.datatables.status',['appointment'=>$appointment])
                            </td>
                            <td>
                                @include('operations.appointment.datatables.action',['appointment'=>$appointment])
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <p>Shown <b>{{ $appointments->firstItem()  }}</b> to <b> {{ $appointments->lastItem() }}</b> From
                        results of <b>{{ $appointments->total() }}</b></p>
                </div>
                <div class="col-md-8 text-right">
                    {{ $appointments->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- <div class="modal fade" id="finishAppointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Finish Appointment</h4>
                </div>
                <form action="{{ route('finish.appointment') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="appointment_id" value="">
                        <div class="form-group">
                            <label for="">Next Followup date</label>
                            <input type="text" name="next_followup" class="form-control datepicker"
                                   placeholder="Next followup date" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Followup note</label>
                            <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('dash/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script> --}}
    {{-- <script src="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script> --}}

    <script>
        $(function () {

            // $('.date-range').daterangepicker({
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     locale: {
            //         format: 'D-MM-YYYY'
            //     }
            // });

            $('.date-range').on('keyup', function(){
                console.log("here");
            })


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

            $(".select2").select2();

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
                        formatedData.push({id: 'dd', text: 'Select Patient'})
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


            $('#finishAppointment').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recipient = button.data('whatever'); // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                $('input[name=appointment_id]').val(recipient);
            })

        })
    </script>
@endsection