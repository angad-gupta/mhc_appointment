<div class="list-group alternative">

    @forelse($notes as $note)
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between row">
                <div class="col-md-8">
                    <p>{!! $note->note !!}</p>
                </div>
                <div class="col-md-4">
                    <p style="margin-left: 150px; margin-top: 15px;">{{ $note->appointment->doctor->title }}. {{ $note->appointment->doctor->full_name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <p class="mb-1">
                        {{ __('appointment.appointment') }} : <a href="{{ route('web.patient.appointment',['id'=>encrypt($note->appointment->id)]) }}">{{ $note->appointment->search_id }}</a>&nbsp;<span>[{{ $note->appointment->schedule_date }}]</span>
                    </p>
                </div>                
                <div class="col-md-2">
                    <p style="margin-left: 12px"> {{ $note->created_at->format('d-M-Y') }}</p>
                </div>
            </div>            
        </div>
    @empty
        <h2 class="text-center pt-5 text-muted">{{__('actions.nothing_found')}}</h2>
    @endforelse

</div>
