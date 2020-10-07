@extends('layouts.app')

@section('title')
    {{ $user->full_name }}
@endsection

@section('css')
    <style>
        .prescriptions {
            position: relative;
        }

        .prescriptions .btn-group {
            position: absolute;
            top: 30%;
            right: 20px;
        }

        .user-image {
            height: 250px;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $user->full_name }}</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="text-center">
                    <div class="user-image">
                        <img src="{{ asset($user->photo ? $user->photo : 'dash/img/boxed-bg.jpg') }}" class="img-responsive" height="150px" alt="">
                    </div>
                    </p>
                    <h3>{{ $user->full_name }}</h3>
                    <p>
                        {{ $user->admin->phone }}
                    </p>
                    <p>
                        {{ $user->admin->address }}
                    </p>
                </div>
                <div class="col-md-9">
                    @include('operations.user-operations-widget.widgets',['user'=>$user])
                </div>
            </div>
        </div>

        <div class="box-footer">

        </div>

    </div>
@endsection

@section('js')

@endsection

