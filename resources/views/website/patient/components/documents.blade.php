@forelse($documents as $document)
    <div class="media shadow mb-4">
{{--        <img src="../../../../assets/images/doctors/doktorka.png" width="100px" class="mr-3" alt="..."/>--}}
        <div class="media-body">
            <h5 class="mt-0">
                {{ $document->title }}
                <small class="float-right mr-5 text-muted">{{ $document->created_at->format('l d M Y') }}</small>
            </h5>
            <p>
                {{ $document->note }}
                <br/>
                <small
                >{{ __('appointment.appointment_id') }} : <a href="{{ route('web.patient.appointment',['id'=>encrypt($document->appointment->id)]) }}">{{ $document->appointment->search_id }}</a> |
{{--                    <a href="" title="Download"><i class="fas fa-download"></i> Download</a> |--}}
                    <a href="{{ showStorageImage($document->directory) }}" target="_blank" title="Expand"><i class="fa fa-expand"></i> Expand</a>
                </small>
            </p>
        </div>
    </div>
@empty
    <h2 class="text-center pt-5 text-muted">{{ __('actions.nothing_found') }}</h2>
@endforelse

