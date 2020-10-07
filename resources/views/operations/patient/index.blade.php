@extends('layouts.app')

@section('title')
    {{ __('patient.all_patient') }}
@endsection

@section('css')
    <style>
        @media (min-width: 768px) {
            .dl-horizontal dt {
                width: auto !important;
            }

            .dl-horizontal dd {
                margin-left: 20px !important;
            }
        }
    </style>
@endsection



@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('patient.all_patient') }}</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('patient.index') }}" method="get" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __('appointment.form.select_patient') }}"
                                   value="{{ request()->query('query') }}" name="query" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-8">
                        <div class="form-group">
                            <select name="order" id="" class="form-control">
                                <option {{ request()->query('order') == 'asc' ? 'selected' : '' }} value="asc">A - Z</option>
                                <option {{ request()->query('order') == 'desc' ? 'selected' : '' }} value="desc">Z- A</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-4">
                        <button type="submit" class="btn btn-primary btn-flat">{{ __('actions.filter') }}</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @forelse($patients as $key=>$patient)
                    <div class="col-md-4">
                        @include('operations.patient.patient-card',['patient'=>$patient,'key'=>$key])
                    </div>

                @empty
                    <div class="not-found">
                        <h1>{{ __('actions.nothing_found') }}</h1>
                        <a href="{{ route('patient.create') }}">{{ __('patient.create_patient') }}</a>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 text-right">
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

