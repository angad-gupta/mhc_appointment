@extends('layouts.app')

@section('title')

@endsection

@section('content')
    <div class="box box-primary">


        <div class="box-header with-border">
            <h3 class="box-title">Edit Payment</h3>

        </div>

        <form action="{{ route('patient-payment.update',['id'=>$payment->id]) }}" method="post">
            <div class="box-body">
                @csrf
                @method('put')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Payment Amount</label>
                        <input type="text" value="{{ $payment->payment_amount }}" name="payment_amount"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Payment Type</label>
                        <select name="payment_type" id="" class="form-control">
                            <option {{ $payment->payment_type == 1 ? 'selected' : '' }} value="1">Cash Payment</option>
                            <option {{ $payment->payment_type == 2 ? 'selected' : '' }} value="2">Check Payment</option>
                            <option {{ $payment->payment_type == 3 ? 'selected' : '' }} value="3">Card Payment</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Payment Note</label>
                        <textarea name="payment_info" id="" cols="30" rows="3"
                                  class="form-control">{{ $payment->payment_info }}</textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-success btn-sharp">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('js')

@endsection

