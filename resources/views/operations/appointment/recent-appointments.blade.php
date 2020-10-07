@extends('layouts.app')

@section('title')
    {{ __('appointment.all_appointment') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
    <style>
        .department {

        }


        .loader {
            color: var(--color-primary);
            font-size: 5rem;
            top: 40%;
            text-indent: -9999em;
            overflow: hidden;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            margin: 72px auto;
            position: relative;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load6 1.7s infinite ease, round 1.7s infinite ease;
            animation: load6 1.7s infinite ease, round 1.7s infinite ease;
        }

    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('appointment.all_appointment') }}</h3>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-bordered table-hover" id="ajaxDatatable">
                <thead>
                <tr>
                    <th width="2%">{{ __('actions.serial') }}</th>
                    <th width="15%">{{ __('appointment.appointment_id') }}</th>
                    <th width="20%">{{ __('patient.patient') }}</th>
                    <th width="20%">{{ __('doctor.doctor') }}</th>
                    <th width="5%">{{ __('actions.status') }}</th>
                    <th width="15%">{{ __('actions.actions') }}</th>
                </tr>
                </thead>
                <tbody>

                @forelse($appointments as $key=>$appointment)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td> @include('operations.appointment.datatables.appointment-details',['appointment'=>$appointment]) </td>
                        <td> @include('operations.appointment.datatables.patient',['appointment'=>$appointment]) </td>
                        <td>
                            @include('operations.appointment.datatables.doctor',['appointment'=>$appointment])
                        </td>
                        <td>@include('operations.appointment.datatables.status',['appointment'=>$appointment])</td>
                        <td>@include('operations.appointment.datatables.action',['appointment'=>$appointment])</td>
                    </tr>
                @empty

                @endforelse

                </tbody>
            </table>
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
                    <h4 class="modal-title" id="myModalLabel">{{ __('appointment.finish_appointment') }}</h4>
                </div>
                <form action="{{ route('finish.appointment') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="appointment_id" value="">
                        <div class="form-group">
                            <label for="">{{ __('mail.your_next_followup_date') }}</label>
                            <input type="text" name="next_followup" class="form-control datepicker"
                                   placeholder="Next followup date" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('appointment.create_followup_note') }}</label>
                            <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('actions.submit') }}</button>
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
    <script>
        $(function () {

            $('#ajaxDatatable').DataTable({
                responsive: true
            })


            $('#finishAppointment').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                $('input[name=appointment_id]').val(recipient)
            })

        })
    </script>
@endsection