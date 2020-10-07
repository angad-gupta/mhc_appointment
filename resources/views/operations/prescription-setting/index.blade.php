@extends('layouts.app')

@section('title')
    {{ __('prescription-setting.prescription_setting') }} -> {{ __('doctor.all_doctor') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/datatables.net-bs/css/responsive.dataTables.min.css') }}">
@endsection


@section('content')
    <div class="box box-primary presription">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription-setting.prescription_setting') }}</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                        <th>{{ __('actions.serial') }}</th>
                        <th>{{ __('doctor.doctor') }}</th>
                        <th>{{ __('prescription.prescription_setting.show_top_left') }}</th>
                        <th>{{ __('prescription.prescription_setting.show_top_right') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prescription_settings as $key=>$setting)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $setting->doctor->full_name }}</td>
                            <td>
                                {{ $setting->show_top_left == 1 ? 'Show' : 'Not to shown' }}

                                {!! $setting->top_left !!}
                            </td>
                            <td>
                                {{ $setting->show_top_right == 1 ? 'Show' : 'Not to shown' }}

                                {!! $setting->top_right !!}
                            </td>
                            <td>
                                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                                    <a href="{{ route('prescription-settings.edit',['id'=>encrypt($setting->id)]) }}"
                                       class="btn btn-success"><i class="fa fa-pencil-square-o"></i> {{ __('actions.edit') }}</a>
                                    <button onclick="$(this).confirmDelete('#delete{{$key}}')" type="button"
                                            class="btn btn-danger"><i class="fa fa-ban"></i> {{ __('actions.delete') }}
                                    </button>
                                    <form action="{{ route('prescription-settings.destroy',['id'=>encrypt($setting->id)]) }}"
                                          id="delete{{$key}}"
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
@endsection
