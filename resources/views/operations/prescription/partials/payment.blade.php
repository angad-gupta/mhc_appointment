<div class="row">
    <form action="{{ route('patient-payment.store') }}" method="post">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
        <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
        <div class="col-md-6">
            <div class="form-group">
                <label for=""> {{ __('payment.form.payment_amount') }}</label>
                <input type="text" name="payment_amount" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('payment.payment_type') }}</label>
                <select name="payment_type" id="" class="form-control">
                    <option value="1">Cash Payment</option>
                    <option value="2">Check Payment</option>
                    <option value="3">Card Payment</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">{{ __('payment.title') }} {{ __('note.note') }}</label>
                <textarea name="payment_info" id="" cols="30" rows="3" class="form-control"></textarea>
            </div>


            <button class="btn btn-success btn-sharp">{{ __('actions.submit') }}</button>
        </div>


    </form>


    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('actions.serial') }}</th>
                <th>{{ __('payment.title') }}</th>
                <th>{{ __('note.note') }}</th>
                <th>{{ __('payment.payment_type') }}</th>
                <th>{{ __('payment.taken_by') }}</th>
                <th>{{ __('actions.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointment->payments as $key=>$payment)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $payment->payment_amount }}</td>
                    <td>{{ $payment->note }}</td>
                    @if($payment->payment_type == 1)
                        <td>Cash Payment</td>
                    @elseif($payment->payment_type == 2)
                        <td>Check Payment</td>
                    @else
                        <td>Card Payment</td>
                    @endif
                    {{-- <td>{{ $payment->createdBy->user_name }}</td> --}}
                    <td>
                        <button class="btn btn-primary" onclick="openPopUp('{{ route('patient-payment.show',['id'=>encrypt($payment->id)]) }}')" ><i class="fa fa-print"></i></button>
                        <form action="{{ route('patient-payment.destroy',['id'=>$payment->id]) }}" method="post" onsubmit="return validate(this)">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>


</div>

<script>
    function validate(form) {
        var con = confirm('You want to delete this ?');
        if (con) {
            return true;
        } else {
            return false;
        }
    }

    function openPopUp(src) {
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
        window.open(src, 'Open', params);
    }
</script>