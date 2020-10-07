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
            <form action="{{ route('patient.index') }}" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control" value="{{ request()->query('query') }}" name="query" type="text" placeholder="Search by phone number or full name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="order" class="form-control">
                                <option {{ request()->query('order') == 'ase' ? 'selected' : '' }} value="ase">A - Z</option>
                                <option {{ request()->query('order') == 'desc' ? 'selected' : '' }} value="desc">Z - A</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            <button class="btn btn-primary btn-flat"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                @forelse($patients as $key=>$patient)
                    <div class="col-md-4 col-xl-3">
                        @include('operations.patient.patient-card',['patient'=>$patient, 'key'=>$key])
                    </div>
                @empty
                    <div class="not-found">
                        <h1>No patient Found</h1>
                        <a href="{{ route('patient.create') }}">Create a patient</a>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <center>
                    {{ $patients->links() }}
                </center>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

