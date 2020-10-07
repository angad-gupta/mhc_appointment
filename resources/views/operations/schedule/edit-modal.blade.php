<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">{{ __('schedule.edit_schedule') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action="" method="post" id="update_form">
                @csrf
                @method('put')
                {{-- need to encrypt id here --}}
                <input type="hidden" id="edit-schedule-id" value="" name="schedule_id">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">{{ __('schedule.day') }} <span class="text-danger">*</span> </label>
                            <input type="text" readonly value="" id="edit-day-index" class="form-control" required placeholder="{{ __('schedule.day') }}">
                        </div>
                    </div>
                    <div class="col-md-4 bootstrap-timepicker">
                        <div class="form-group">
                            <label for="">{{ __('schedule.start_time') }} <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" name="start_time" id="start-time" class="form-control timepicker" required placeholder="{{ __('schedule.start_time') }}">
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
                                <input type="text" autocomplete="off" name="end_time" id="end-time" class="form-control timepicker" required placeholder="{{ __('schedule.end_time') }}">
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
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>