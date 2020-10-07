@extends('layouts.app')

@section('title')
    {{ __('patient.patient') }} -> {{ __('payment.title') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection


@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title">{{ __('payment.title') }}</h1>
        </div>

        <div class="box-body">
            <form class="row " action="" method="get">
                <div class="col-md-2 form-group">
                    <label for="">{{ __('patient.select_patient') }}</label>
                    <select name="patient" id="selectPatient" class="form-control">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label for="">{{ __('doctor.select_doctor') }}</label>
                    <select name="doctor" id="" class="form-control select2">
                        <option value="">{{ __('doctor.select_doctor') }}</option>
                        @foreach(\App\Models\Doctor::all() as $doctor)
                            <option value="{{ $doctor->id }}" {{ setSelectOption(request()->query('doctor'),$doctor->id) }}>{{
                                $doctor->title . ' '. $doctor->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label for="">{{ __('payment.taken_by') }}</label>
                    <select name="taken_by" class="form-control select2">
                        <option value="">Select User</option>
                        @foreach(\App\User::all() as $user)
                            <option value="{{ $user->id }}" {{ setSelectOption(request()->query('taken_by'),$user->id) }}>{{
                                $user->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">{{ __('appointment.form.date_range') }}</label>
                    <input type="text" name="date_range" value="{{ request()->query('date_range') }}"
                           placeholder="{{ __('appointment.form.date_range') }}"
                           class="form-control date-range" autocomplete="off">
                </div>
                <div class="col-md-1 form-group">
                    <label for="">{{ __('actions.sort_by') }}</label>
                    <select name="sort_by" class="form-control">
                        <option value="asc" {{ setSelectOption(request()->query('sort_by'), 'asc') }}>A-Z</option>
                        <option value="desc" {{ setSelectOption(request()->query('sort_by'), 'desc') }}>Z-A</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for=""></label>
                    <button type="submit" class="btn btn-primary btn-flat btn-block">{{ __('actions.filter') }}</button>
                    <a target="_blank"
                       href="{{ route('report.payment','patient='.request()->query('patient').'&doctor='.request()->query('doctor').'&taken_by='.request()->query('taken_by').'&date_range='.request()->query('date_range').'&sort_by='.request()->query('sort_by')) }}">{{ __('actions.download_pdf') }}</a>
                </div>

            </form>

            <hr>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('schedule.date') }}</th>
                        <th>{{ __('patient.patient') }}</th>
                        <th>{{ __('appointment.appointment') }}</th>
                        <th>{{ __('payment.form.payment_amount') }}</th>
                        <th>{{ __('payment.payment_type') }}</th>
                        <th>{{ __('payment.payment_info') }}</th>
                        <th>{{ __('payment.paid_to') }}</th>
                        <th>{{ __('payment.taken_by') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($payments as $key=>$payment)
                        <tr>
                            <td>{{ $payments->firstItem() + $key }}</td>
                            <td>{{ $payment->created_at->format('d-m-Y') }}
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button"
                                            onclick="openPopUp('{{ route('patient-payment.show',['id'=>encrypt($payment->id)]) }}')"
                                            class="btn btn-success"><i class="fa fa-print"></i></button>

                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$key}}">
                                        <i class="fa fa-envelope"></i></button>

                                    <div class="modal fade" id="myModal{{$key}}" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">{{ __('payment.title') }} {{ __('actions.email') }}</h4>
                                                </div>
                                                <form action="{{ route('mail.payment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="payment_id"
                                                           value="{{ encrypt($payment->id) }}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">{{ __('actions.email') }}</label>
                                                            <input type="email" required
                                                                   name="email"
                                                                   value="{{ $payment->appointment->patient->contact_email }}"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">{{ __('actions.cancel') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary"> {{ __('mailbox.send_mail') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('patient.show',['id'=>encrypt($payment->patient->id)]) }}">{{ $payment->patient->title }} {{ $payment->patient->full_name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('appointment.show',['id'=>encrypt($payment->appointment->id)]) }}">{{ $payment->appointment->search_id }}</a>
                            </td>
                            <td>{{ $payment->payment_amount }}</td>
                            <td>
                                @if($payment->payment_type == 1)
                                    Cash Payment
                                @elseif($payment->payment_type == 2)
                                    Check Payment
                                @else
                                    Card Payment
                                @endif
                            </td>
                            <td>{{ $payment->payment_info }}</td>
                            <td>
                                <a href="{{ route('doctor.show',['id'=>encrypt($payment->doctor->id)]) }}">{{ $payment->doctor->title . ' ' . $payment->doctor->full_name }}</a>
                            </td>
                            {{-- <td>{{ $payment->createdBy->full_name }}</td> --}}
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <p>Shown <b>{{ $payments->firstItem()  }}</b> to <b> {{ $payments->lastItem() }}</b> From
                        results of <b>{{ $payments->total() }}</b></p>
                </div>
                <div class="col-md-8 text-right">
                    {{ $payments->appends(request()->all())->links() }}
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

        function openPopUp(src) {
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
            window.open(src, 'Open', params);
        }

        $(function () {
            var hash = window.location.hash;
            console.log(hash);
            if (hash != '') {
                $('#mainTabs a[href="' + hash + '"]').tab('show');
                $('.nav-tabs li').removeClass('active');
                $('.nav-tabs li a').each(function (index, value) {
                    if (value.hash == hash) {
                        value.parentNode.className = 'active';

                    }
                })
            }
        })

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
                        // console.log(data);
                    }
                }
            });
        })
    </script>
@endsection

