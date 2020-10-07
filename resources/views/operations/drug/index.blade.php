@extends('layouts.app')

@section('title')
    {{ __('drug.all_drug') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">{{ __('drug.all_drug') }}</div>
        </div>
        <div class="box-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ __('actions.serial') }}</th>
                    <th>{{ __('drug.trade_name') }}</th>
                    <th>{{ __('drug.generic_name') }}</th>
                    <th>{{ __('actions.status') }}</th>
                    <th>{{ __('department.department') }}</th>
                    <th width="150px">{{ __('actions.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drugs as $key=>$drug)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $drug->trade_name }}</td>
                        <td>{{ $drug->generic_name }}</td>
                        <td>
                            @if($drug->status == 1)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">In Active</span>
                            @endif
                        </td>
                        <td>{{ $drug->department ? $drug->department->title : 'All Department' }}</td>
                        <td>
                            @if(auth()->user()->role == 1 || auth()->user()->id == $drug->created_by)
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a href="{{ route('drug.edit',['id'=>encrypt($drug->id)]) }}"
                                       class="btn btn-success"><i
                                                class="fa fa-pencil"></i></a>
                                    <button onclick="$(this).confirmDelete($('#delete{{$key}}'))" type="button"
                                            class="btn btn-danger"><i
                                                class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <form action="{{ route('drug.destroy',['id'=>encrypt($drug->id)]) }}"
                                      id="delete{{$key}}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endif
                        </td>
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
@endsection

