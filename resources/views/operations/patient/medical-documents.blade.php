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
            <h3 class="box-title">Patient Medical Document</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Note</th>
                    @admin
                    <th>Action</th>
                    @endadmin
                </tr>
                </thead>
                <tbody>
                @foreach($patient->medicalDocuments as $key=>$document)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $document->title }}</td>
                        <td>
                            {{ $document->file }}
                        </td>
                        <td>
                            {{ $document->note }}
                        </td>
                        @admin
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="{{ route('patient-payment.edit',['id'=>encrypt($document->id)]) }}"
                                   class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                <button type="button" onclick="$(this).confirmDelete($('#paymentDelete{{$key}}'))"
                                        class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                <form action="{{ route('patient-payment.destroy',['id'=>encrypt($document->id)]) }}"
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

