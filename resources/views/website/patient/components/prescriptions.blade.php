<div class="list-group alternative">

    @forelse($prescriptions as $prescription)

        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">CC : {{ $prescription->inspection->chief_complains }}</h5>
                <small><a href="{{ route('prescription.print',['id'=>encrypt($prescription->id)]) }}" target="_blank"><i
                                class="fa fa-print"></i> Print</a></small>
            </div>
            <p class="mb-1">
                {{ __('drug.drug') }} :
                @foreach($prescription->drugs as $drug)
                    <span class="badge badge-pill badge-primary">{{ $drug->name }}</span>
                @endforeach
            </p>
            <small>{{ __('appointment.appointment_id') }} : <a
                        href="{{ route('web.patient.appointment',['id'=>encrypt($prescription->appointment->id)]) }}">{{ $prescription->appointment->search_id }}</a>
                | {{ __('doctor.full_name') }} : <a href="">{{ $prescription->doctor->full_name }}</a></small>
            <small class="float-right">{{ $prescription->created_at->format('l d M Y') }}</small>

        </div>
    @empty
        <h2 class="text-center pt-5 text-muted">{{ __('actions.nothing_found') }}</h2>
    @endforelse

</div>

