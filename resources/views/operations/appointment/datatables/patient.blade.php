<div class="media">
    <div class="media-body">
        <h4 class="media-heading">{{ $appointment->patient->title }} {{ $appointment->patient->full_name }}</h4>
        <p><span class="label label-success">{{ $appointment->patient->sex }}</span></p>
        <p>{{ $appointment->patient->cell_phone }} <br> {{ $appointment->patient->contact_email }}</p>
        <a href="{{ route('patient.show',['id'=>encrypt($appointment->patient->id)]) }}"><i class="fa fa-eye"></i> {{ __('actions.view') . ' ' .__('patient.patient') }}</a>
    </div>
</div>