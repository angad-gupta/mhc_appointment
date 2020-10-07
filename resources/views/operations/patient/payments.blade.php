    @extends('layouts.app')

    @section('title')
        Patient Payment
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    @endsection

    @section('content')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Patient payments</h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Payment Amount</th>
                        <th>Payment Type</th>
                        <th>Payment Note</th>
                        @admin
                        <th>Action</th>
                        @endadmin
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patient->payments as $key=>$payment)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ number_format($payment->payment_amount,2) }}
                            </td>
                            <td>
                                @if($payment->payment_type == 1)
                                    Cash Payment
                                @elseif($payment->payment_type == 2)
                                    Check Payment
                                @else
                                    Card Payment
                                @endif
                            </td>
                            <td> {{ $payment->payment_info }}</td>
                            @admin
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a href="{{ route('patient-payment.edit',['id'=>encrypt($payment->id)]) }}"
                                       class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                    <button type="button" onclick="$(this).confirmDelete($('#paymentDelete{{$key}}'))"
                                            class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    <form action="{{ route('patient-payment.destroy',['id'=>encrypt($payment->id)]) }}"
                                          method="post" id="paymentDelete{{$key}}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            </td>
                            @endadmin
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    @endsection

    @section('js')
        <script src="{{ asset('dash/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
        <script>
            $(function () {
                $('#example1').dataTable()
            })
        </script>
    @endsection

