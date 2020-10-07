<div class="btn-group btn-group-xs">
    @if($appointment->status == 1 || $appointment->status == 3)
        <a href="{{ route('appointment.edit',['id'=>encrypt($appointment->id)]) }}" class="btn btn-primary btn-xs"><i
                    class="fa fa-edit"></i> Reschedule </a>
    @endif
    <a href="{{ route('appointment.show',['id'=> encrypt($appointment->id)]) }}" class="btn btn-success btn-xs"><i
                class="fa fa-eye"></i> {{__('actions.view')}} </a>
    @if($appointment->status == 1)
        {{-- <button onclick="$(this).confirmDelete($('#deleteAppointment{{$appointment->id}}'))"
                class="btn btn-danger btn-xs">
            <i class="fa fa-ban"></i> {{ __('actions.cancel') }}
        </button> --}}

        <form action="{{ route('appointment.destroy',['id'=>encrypt($appointment->id)]) }}"
              id="deleteAppointment{{$appointment->id}}" method="post">
            @csrf
            @method('delete')
        </form>
    @endif
</div>
<br>
<div class="btn-group btn-group-xs" style="margin-top: 10px;">
    <a href="{{ route('appointment.show',['id'=>encrypt($appointment->id).'#payment']) }}"
       class="btn bg-aqua-active btn-xs"><i class="fa fa-money"></i> {{ __('payment.title') }} </a>
    <a href="{{ route('appointment.show',['id'=>encrypt($appointment->id).'#documents']) }}"
       class="btn bg-fuchsia btn-xs"><i class="fa fa-file-pdf-o"></i> {{ __('document.document') }}</a>
    <a href="{{ route('appointment.show',['id'=>encrypt($appointment->id).'#note']) }}" class="btn btn-info btn-xs"><i
                class="fa fa-sticky-note"></i> {{ __('note.note') }}</a>
</div>


{{--// action work only if doctor--}}
@doctor

@if($appointment->status == 3)
    <br>
    <br>
    <button onclick="$(this).confirmSubmit($('#startAppointment{{$appointment->id}}'))" type="submit"
            class="btn btn-primary btn-xs">
        <i class="fa fa-play-circle-o"></i> {{ __('appointment.start_appointment') }}
    </button>

    <form action="{{ route('start.appointment') }}" id="startAppointment{{$appointment->id}}" method="post">
        @csrf
        <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
    </form>
@elseif($appointment->status == 1)
    <br>
    <br>
    <button appointment-id="{{ $appointment->id }}"
            class="btn-approve btn btn-success btn-xs">
        <i class="fa fa-play-circle-o"></i> Approve
    </button>
    <button id="btn-cancel" appointment-id="{{ $appointment->id }}"
        class="btn btn-danger btn-xs">
    <i class="fa fa-play-circle-o"></i> Reject
</button>
@endif

@if($appointment->status == 4)
    <div class="btn-group btn-group-xs" style="margin-top: 10px;">
        <a class="btn btn-success"
           href="{{ route('prescription.create','patient='.encrypt($appointment->patient_id).'&appointment='.encrypt($appointment->id)) }}">
            <i class="fa fa-play"></i> {{ __('appointment.resume') }}
        </a>
        <button data-toggle="modal" data-target="#finishAppointment" data-whatever="{{ encrypt($appointment->id) }}"
                class="btn btn-danger btn-xs"><i class="fa fa-flag-checkered"></i> {{ __('appointment.finish_appointment') }}
        </button>
        {{-- modal on finish appointment --}}
        @include('operations.appointment.finish-appointment', ['appointment_id' => $appointment->id])

    </div>
@endif
@enddoctor

@section('js')
    <script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function(){

            $.ajax({
                type: "get",
                url: "{{route('get.doctor')}}",
                data: {"doctor_id": {!! $appointment->doctor->id !!},"video_consultation" : true},
                success: function(data) {
                    scheduleDays = data.scheduleDays;
                    var disableDate = [];
                    $('.datepicker').datepicker({
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
                    })

                },
                error:function(data)
                {
                    alert("Server error");
                }
            });
            

            //confirm on approve
            $(".btn-approve").on('click', function(){
                var appointmentId = $(this).attr('appointment-id');
                swal({
                    title: "Are you sure you want to confirm?",
                    showConfirmButton: true,
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }).then(function(confirm){
                    if(confirm) {
                        $("#loader").show();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('appointment.status.change') }}',
                            type: "POST",
                            data: {
                                appointment_id: appointmentId,
                                status: 3
                            },
                            success: function(res) {
                                $("#loader").hide();
                                swal({
                                    title: "Appointment Confirmed"
                                }).then(function(){
                                    location.reload();
                                });
                            },
                            error: function() {
                                $("#loader").hide();
                            }
                        });
                    }
                });
            });

            //on cancel
            $("#btn-cancel").on('click', function(){
                var appointmentId = $(this).attr('appointment-id');
                swal({
                    title: "Are you sure you want to cancel?",
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    dangerMode: true,
                }).then(function(confirm){
                    if(confirm) {
                        $("#loader").show();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('appointment.status.change') }}',
                            type: "POST",
                            data: {
                                appointment_id: appointmentId,
                                status: 0
                            },
                            success: function(res) {
                                $("#loader").hide();
                                swal({
                                    title: "Appointment Canceled"
                                }).then(function(){
                                    location.reload();
                                });
                            },
                            error: function() {
                                
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

<div class="modal fade" id="exampleModal{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">{{ __('appointment.status.change_status') }}</h4>
            </div>
            <div class="modal-body">
                @if($appointment->status == 0)
                    <div class="row">
                        @admin
                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(1) }}" name="status">
                                <button type="submit" class="btn btn-warning btn-block"><i
                                            class="fa  fa-hourglass-end"></i> {{ __('appointment.status.pending') }}</button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(3) }}" name="status">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('appointment.status.confirm') }}</button>
                            </form>
                        </div>
                        @else
                            <h4 class="text-center">{{ __('appointment.status.only_admin_can_change_this_status') }}</h4>
                            @endadmin
                    </div>
                @elseif($appointment->status == 1)
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(0) }}" name="status">
                                <button type="submit" class="btn btn-danger btn-block"><i
                                            class="fa fa-ban"></i> {{ __('appointment.status.cancel') }}</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(3) }}" name="status">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('appointment.status.confirm') }}</button>
                            </form>
                        </div>

                    </div>
                @elseif($appointment->status == 2)
                    <h4>{{ __('appointment.status.status_cannot_be_change') }}</h4>
                    <p>{{ __('appointment.status.not_even_admin') }}</p>
                @elseif($appointment->status == 3)
                    <strong>Frequent Cancellation of appointments are tracked and is not recommended and is subject to be penalized later</strong>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(0) }}" name="status">
                                <button type="submit" class="btn btn-danger btn-block"><i
                                            class="fa fa-ban"></i> {{ __('appointment.status.cancel') }}</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('appointment.status.change') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                                <input type="hidden" value="{{ encrypt(1) }}" name="status">
                                <button type="submit" class="btn btn-warning btn-block"><i
                                            class="fa  fa-hourglass-end"></i> {{ __('appointment.status.pending') }}</button>
                            </form>
                        </div>
                    </div>
                @elseif($appointment->status == 4)
                    <h4>{{ __('appointment.status.status_cannot_be_change') }}</h4>
                    <p>{{ __('appointment.status.status_can_only_change_to') }} <span
                                class="label label-primary">{{ __('appointment.status.complete') }}</span></p>
                @endif


            </div>
        </div>
    </div>
</div>