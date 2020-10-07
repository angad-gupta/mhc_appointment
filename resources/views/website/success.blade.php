@extends('website.components.app')

@section('title') {{ __('website.error_page.title') }} @endsection

@section('content')
    <link href=https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css rel=stylesheet>
    <div class="confirm">
        <div class="container-fluid">
            <i class="ion-ios-checkmark-circle-outline"></i>
            <h1>{{ request()->query('title') }}</h1>
            <p>{{ request()->query('message') }}</p>
            <a href="" class="btn btn-primary rounded-0">{{ __('website.error_page.back_to_home') }}</a>
        </div>
    </div>
@endsection