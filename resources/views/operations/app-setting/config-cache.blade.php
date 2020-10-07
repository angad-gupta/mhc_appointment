@extends('website.components.app')

@section('title') Config Cache @endsection

@section('content')
    <link href=https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css rel=stylesheet>
    <div class="confirm">
        <div class="container-fluid">
            <i class="ion-ios-checkmark-circle-outline"></i>
            <h1>Success</h1>
            <p>Server cache has been re-config successfully.</p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-0">{{ __('website.error_page.back_to_home') }}</a>
        </div>
    </div>
@endsection