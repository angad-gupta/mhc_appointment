@if($appointment->status == 0)
    <p style="display: none">0</p>
    <span class="label label-danger">
        {{ __('appointment.status.cancel') }}
    </span>
@elseif($appointment->status == 1)
    <p style="display: none">1</p>
    <span class="label label-warning">
        {{ __('appointment.status.pending') }}
    </span>
@elseif($appointment->status == 2)
    <p style="display: none">2</p>
    <span class="label label-success">
        {{ __('appointment.status.complete') }}
    </span>
@elseif($appointment->status == 3)
    <p style="display: none">3</p>
    <span class="label label-primary">
        {{ __('appointment.status.confirm') }}
    </span>
@elseif($appointment->status == 4)
    <p style="display: none">4</p>
    <span class="label label-default">
        {{ __('appointment.status.on_process') }}
    </span>
@endif