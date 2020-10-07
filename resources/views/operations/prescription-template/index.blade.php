@extends('layouts.app')

@section('title')
    {{ __('prescription.prescription_template.all_template') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary presription">


        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription.prescription_template.all_template') }}</h3>
        </div>


        <div class="box-body">
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                    <tr>
                        <th>{{ __('actions.serial') }}</th>
                        <th>{{ __('prescription.prescription_template.template_name') }}</th>
                        <th>{{ __('doctor.description') }}</th>
                        <th width="150px">{{ __('actions.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($templates as $key=>$template)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->description }}</td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                    <a href="{{ route('prescription-template.edit',['id'=>encrypt($template->id)]) }}"
                                       class="btn btn-success"><i class="fa fa-pencil-square-o"></i>
                                        Edit
                                    </a>
                                    <a href="{{ route('prescription-template.show',['id'=>encrypt($template->id)]) }}"
                                       class="btn btn-info"><i class="fa fa-eye"></i> View</a>
                                    <button type="button" onclick="$(this).confirmDelete($('#delete{{$key}}'))"
                                            class="btn btn-danger"><i class="fa fa-trash-o"> Delete</i>
                                    </button>
                                    <form id="delete{{$key}}"
                                          action="{{ route('prescription-template.destroy',['id'=>encrypt($template->id)]) }}"
                                          method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $("#table").dataTable();
        })
    </script>
@endsection

