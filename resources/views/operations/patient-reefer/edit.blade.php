@extends('layouts.app')

@section('title')
    Patient Reefer
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection


@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Patient Reefer</h3>
        </div>
        <div class="box-body">
            <div id="app">
                <patient-reefer :patient_id="{{ $patient->id }}"></patient-reefer>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

