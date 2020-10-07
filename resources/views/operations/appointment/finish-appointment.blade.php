<!-- Modal -->
<div class="modal fade" id="finishAppointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ __('appointment.finish_appointment') }}</h4>
            </div>
            <form action="{{ route('finish.appointment') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="appointment_id" value="{{ encrypt($appointment->id) }}">
                    <div class="form-group">
                        <label for="">{{ __('appointment.follow_up_date') }}</label>
                        <input type="text" name="next_followup" class="form-control datepicker" placeholder="{{ __('appointment.follow_up_date') }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('appointment.create_followup_note') }}</label>
                        <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('actions.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('actions.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>