@extends('layouts.app')

@section('title')
    {{ __('department.all_department') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">{{ __('department.department') }}</div>
        </div>
        <div class="box-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="20px">{{ __('actions.serial') }}</th>
                    <th>{{ __('department.title') }}</th>
                    <th width="30px">{{ __('actions.status') }}</th>
                    <th width="150px">{{ __('actions.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $key=>$department)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $department->title }}</td>
                        <td>
                            @if($department->status == 1)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">InActive</span>
                            @endif
                        </td>
                        <td>
                            @admin
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="{{ route('department.edit',['id'=>encrypt($department->id)]) }}"
                                   class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                <button onclick="$(this).confirmDelete($('#departmentDelete{{$key}}'))" type="button"
                                        class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                <form action="{{ route('department.destroy',['id'=>encrypt($department->id)]) }}"
                                      method="post"
                                      id="departmentDelete{{$key}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                            @endadmin
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

