@extends('layouts.app')

@section('title')
    {{ __('dashboard.dashboard') }}
@endsection

@section('content')

    @admin
        @include('operations.dashboard.admin')
    @endadmin

    @doctor
        @include('operations.dashboard.doctor')
    @enddoctor

@endsection
