<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') </title>

    @include('layouts.assets.css')

@yield('video_api')
</head>
@if (Session::has('appointment_starting'))
<div class="container">
    <div class="row">
        <div>
        <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success alert-dismissible fade show" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; bottom: 20px; right: 10px; animation-iteration-count: 1;">
            <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <h4 class="h5">
            <i class="fa fa-check-circle-o"></i>
            Appointment
            </h4>
            <p>{!!Session::get('appointment_starting')!!}</p>
        </div>
        </div>
    </div>
</div>
@endif
<body class="sidebar-mini skin-red-light fixed">
<div id="loader">
    <div id="content">
        <img src="{{ asset('dash/img/spinner.gif') }}" alt="">
        <p>Please wait</p>
    </div>
</div>

<div class="wrapper">
@include('layouts.partials.nav')

    @admin
        @include('layouts.partials.sidebar.admin')
    @endadmin

    @doctor
        @include('layouts.partials.sidebar.doctor')
    @enddoctor

    @assistant
        @include('layouts.partials.sidebar.assistant')
    @endassistant

<!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    {{--<section class="content-header">--}}
    {{--<h1>--}}
    {{--Blank page--}}
    {{--<small>it all starts here</small>--}}
    {{--</h1>--}}
    {{--<ol class="breadcrumb">--}}
    {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
    {{--<li><a href="#">Examples</a></li>--}}
    {{--<li class="active">Blank page</li>--}}
    {{--</ol>--}}
    {{--</section>--}}

    <!-- Main content -->
        <section class="content">
            
            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 0.1
        </div>
        <strong>Copyright &copy; 2020 Merohealth Care.</strong> All rights
        reserved.
    </footer>

    <div class="control-sidebar-bg"></div>

</div>

@include('layouts.assets.js')
@include('layouts.assets.session_message')
@yield('js')
</body>
</html>