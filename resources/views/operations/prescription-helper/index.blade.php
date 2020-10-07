@extends('layouts.app')

@section('title')
    Prescription Helper {{ config('app.name') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">

@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription-helper.all') }}</h3>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                    <tr>
                        <th width="50px">SL</th>
                        <th>{{ __('prescription-helper.helper_text') }}</th>
                        <th width="100px">{{ __('prescription-helper.category') }}</th>
                        @if(auth()->user()->role != 2)
                            <th>{{ __('actions.created_by') }}</th>
                        @endif
                        <th width="150px">{{ __('actions.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prescription_helpers as $key=>$prescription_helper)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $prescription_helper->helper_text }}</td>
                            <td>
                                @if($prescription_helper->category == 0)
                                    <span class="badge badge-success"> All</span>
                                @elseif($prescription_helper->category == 1)
                                    <span class="badge badge-success"> Chief Complains</span>
                                @elseif($prescription_helper->category == 2)
                                    <span class="badge badge-success"> On Examinations</span>
                                @elseif($prescription_helper->category == 3)
                                    <span class="badge badge-success"> Provisional Diagnosis</span>
                                @elseif($prescription_helper->category == 4)
                                    <span class="badge badge-success"> Differential Diagnosis</span>
                                @elseif($prescription_helper->category == 5)
                                    <span class="badge badge-success"> Lab Workup</span>
                                @elseif($prescription_helper->category == 6)
                                    <span class="badge badge-success"> Advices</span>
                                @endif
                            </td>
                            @if(auth()->user()->role != 2)
                                <td></td>
                            @endif
                            <td>
                                @if(auth()->user()->role == 1 ||  $prescription_helper->created_by == auth()->user()->id)
                                    <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                        <a href="{{ route('prescription-helper.edit',['id'=>encrypt($prescription_helper->id)]) }}"
                                           class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                        <button onclick="$(this).confirmDelete($('#deleteHelper{{$key}}'))" type="button" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>

                                    <form id="deleteHelper{{$key}}" action="{{ route('prescription-helper.destroy',['id'=>$prescription_helper]) }}"
                                          method="post">
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

