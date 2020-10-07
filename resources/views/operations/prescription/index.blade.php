@extends('layouts.app')

@section('title')
    {{ __('prescription.all_prescription') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription.all_prescription') }}</h3>
        </div>

        <div class="box-body">

            <form class="row" action="" method="get">

                <div class="col-md-3 form-group">
                    <label for="">{{ __('prescription.prescription') }} {{ __('actions.serial') }}</label>
                    <input type="text" class="form-control" name="prescription" placeholder="{{ __('prescription.prescription') }} {{ __('actions.serial') }}" value="{{ request()->query('prescription') }}">
                </div>

                <div class="col-md-3 form-group">
                    <label for="">{{ __('appointment.form.date_range') }}</label>
                    <input name="date_range"
                           type="text"
                           class="form-control date-range"
                           autocomplete="off"
                           value="{{ $request->query('date_range') }}"
                           placeholder="{{ __('appointment.form.date_range') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">{{ __('patient.select_patient') }}</label>
                    <select name="patient" id="selectPatient" class="form-control">
                        <option value="dd">{{ __('patient.select_patient') }}</option>
                    </select>
                </div>
                @doctor

                @else
                    <div class="col-md-3 form-group">
                        <label for="">{{ __('appointment.form.select_doctor') }}</label>
                        <select name="doctor" id="" class="form-control">
                            <option value="dd">{{ __('appointment.form.select_doctor') }}</option>
                            @foreach(\App\Models\Doctor::all() as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->title }} {{ $doctor->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @enddoctor
                    <div class="col-md-1 form-group">
                        <label for="">{{ __('actions.sort_by') }}</label>
                        <select name="sort_by" class="form-control">
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for=""></label>
                        <button class="btn btn-success btn-flat" type="submit">
                            <i class="fa fa-filter" aria-hidden="true"></i>{{ __('actions.filter') }}
                        </button>
                        <a href="{{ route('report.prescription','date_range='.request()->query('date_range').'&patient='.request()->query('patient').'&doctor='.request()->query('doctor')) }}">{{ __('actions.download_pdf') }}</a>
                    </div>

            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('actions.serial') }}</th>
                        <th>{{ __('prescription.prescription') }}</th>
                        <th>{{ __('schedule.date') }}</th>
                        <th>{{ __('drug.drug') }}</th>
                        <th>{{ __('patient.patient') }}</th>
                        <th>{{ __('doctor.doctor') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($prescriptions as $key=>$prescription)
                        <tr>
                            <td>{{ $prescriptions->firstItem() + $key }}</td>
                            <td>
                                <a href="{{ route('appointment.show',['id'=>encrypt($prescription->appointment_id)]) }}">{{ $prescription->search_id }}</a>
                            </td>
                            <td>
                                {{ $prescription->created_at->format('l d-M-Y') }}
                            </td>
                            <td>
                                @foreach($prescription->drugs as $drug)
                                    <span class="badge badge-pill">{{ $drug->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $prescription->patient->full_name }}
                            </td>
                            <td>
                                {{ $prescription->doctor->full_name }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    <button onclick="printPrescription('{{ route('prescription.print',['id'=>encrypt($prescription->id)]) }}')"
                                            type="button" class="btn btn-success btn-xs">
                                        <i class="fa fa-print"></i> Print
                                    </button> &nbsp;
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal{{$key}}">
                                        <i class="fa fa-envelope-o"></i> Mail
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{$key}}" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                </div>
                                                <form action="{{ route('mail.prescription') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="prescription_id"
                                                           value="{{ encrypt($prescription->id) }}">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="email" required
                                                                   name="email"
                                                                   value="{{ $prescription->patient->contact_email }}"
                                                                   class="form-control">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Send Mail</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>No prescription found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-md-6">
                    <p>Shown <b>{{ $prescriptions->firstItem()  }}</b> to <b> {{ $prescriptions->lastItem() }}</b> From
                        results of <b>{{ $prescriptions->total() }}</b></p>
                </div>
                <div class="col-md-6">
                    {{ $prescriptions->links() }}
                </div>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>

        function printPrescription(src) {
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;
            window.open(src, 'Open', params);
        }

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