@extends('layouts.app')

@section('title')
    {{ __('prescription.prescription_template.create_template') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/css/prescription.css') }}">
@endsection

@section('content')
    <div class="box box-primary presription">


        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription.prescription_template.create_template') }}</h3>
        </div>


        <div class="box-body">
            <div id="app">
                <prescription-template-component></prescription-template-component>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

