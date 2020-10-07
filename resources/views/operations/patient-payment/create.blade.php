@extends('layouts.app')

@section('title')
    Patient Patient
@endsection

@section('css')
    <style>
        .document-block {
            position: relative;
        }

        .document-block iframe {
            height: 250px;
            width: 100%;
        }

        .document-block .expand {
            position: absolute;
            top: 0;
            right: 0;
        }

        .note-block {
            border: 1px solid #e4e4e4;
            margin-top: 25px;
            border-radius: 2px;
            margin-left: 5px;
            margin-right: 5px;
            min-height: 150px;
            position: relative;
        }

        .note-block .btn-group {
            position: absolute;
            right: 0;
            top: -10px;
        }

        .p-5 {
            padding: 25px;

        }

        .prescriptions {
            position: relative;
        }

        .prescriptions .btn-group {
            position: absolute;
            top: 30%;
            right: 20px;
        }

        li.active {
            border-top-color: var(--color-primary) !important;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Payment</h3>
        </div>
        <div class="box-body">

            @include('operations.patient.patient-card-small',['appointment'=>$appointment])

            <form action="{{ route('patient-payment.store','redirect_back=1') }}" method="post">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Payment Amount</label>
                        <input type="text" name="payment_amount" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Payment Type</label>
                        <select name="payment_type" id="" class="form-control">
                            <option value="1">Cash Payment</option>
                            <option value="2">Check Payment</option>
                            <option value="3">Card Payment</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Payment Note</label>
                        <textarea name="payment_info" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>


                    <button class="btn btn-success btn-sharp">Submit</button>
                </div>


            </form>
        </div>
        <div class="box-footer">
            <h4>Previous Payments</h4>
            @forelse($appointment->payments as $payment)
                <div class="list-group prescriptions">
                    <a href="#" class="list-group-item">
                        <p class="text-muted">{{ $payment->created_at->format('l d-m-Y h:i A') }}</p>
                        <h4 class="list-group-item-heading">{{ $payment->payment_amount }}</h4>
                        {{-- <p class="list-group-item-text">
                            {{ $payment->createdBy->user_name }}
                        </p> --}}
                    </a>
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <button type="button"
                                onclick="openPopUp('{{ route('patient-payment.show',['id'=>encrypt($payment->id)]) }}')"
                                class="btn btn-success"><i class="fa fa-print"></i></button>
                        @admin
                        <button type="button" onclick="$(this).confirmDelete($('#deletePayment{{$payment->id}}'))" class="btn btn-danger"><i
                                    class="fa fa-trash"></i>
                        </button>
                        @endadmin
                    </div>
                    @admin
                    <form action="{{ route('patient-payment.destroy',['id'=>$payment->id]) }}" id="deletePayment{{$payment->id}}">
                        @csrf
                        @method('delete')
                    </form>
                    @endadmin
                </div>
            @empty
                <div class="not-found">
                    <h1>Payment not found</h1>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('js')
    <script>
        function openPopUp(src) {
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
            window.open(src, 'Open', params);
        }
    </script>
@endsection

