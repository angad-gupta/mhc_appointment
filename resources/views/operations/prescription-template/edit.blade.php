@extends('layouts.app')

@section('title')
    Edit Prescription Template
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/css/prescription.css') }}">
@endsection

@section('content')
    <div class="box box-primary presription">


        <div class="box-header with-border">
            <h3 class="box-title">Edit Prescription Template</h3>
        </div>


        <div class="box-body">
            <div id="app">
                <prescription-template-edit-component
                        :template_id="{{ decrypt($template_id) }}"></prescription-template-edit-component>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

