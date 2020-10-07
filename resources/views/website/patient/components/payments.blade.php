<div class="list-group alternative">
    @forelse($payments as $payment)
        <div href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">NPR. {{ number_format($payment->payment_amount,2) }}</h5>
                <small><a href="{{ route('payment.print',['id'=>encrypt($payment->id)]) }}" target="_blank"> <i class="fa fa-print"></i> Print</a></small>
            </div>
            @if($payment->payment_info)
                <p class="mb-1">
                    Payment Info : {{ $payment->payment_info }}
                </p>
            @endif
            <small>{{ __('appointment.appointment_id') }} : <a href="{{ route('web.patient.appointment',['id'=>encrypt($payment->appointment->id)]) }}">{{ $payment->appointment->search_id }}</a></small>
            <small class="float-right">{{ $payment->created_at->format('l d M Y') }}</small>
        </div>

    @empty

        <h2 class="text-center pt-5 text-muted">{{ __('actions.nothing_found') }}</h2>
    @endforelse
</div>
