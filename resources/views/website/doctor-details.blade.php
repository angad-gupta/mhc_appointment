@extends('website.components.app')

@section('title')
    {{ $doctor->title }}
@endsection

@section('content')
    <div class="page-banner" style="background-image: url('{{ asset('web/images/b8cb9975d682ff9c6c1aa57192db086e.jpg') }}')">
        <h4 class="title text-center pt-4">
            {{ $doctor->title }} {{ $doctor->full_name }}
            <span>{{ str_limit($doctor->info,80,'...') }}</span>
        </h4>
    </div>

    <div class="single-doctor">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-6">
                    <img src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}" class="img-fluid" alt="" />

                    <div>
                        <h4>{{ $doctor->title }} {{ $doctor->full_name }}</h4>
                        <p class="text-muted">{{ $doctor->info }}</p>

                        <a href="{{ route('w.appointment','doctor='.encrypt($doctor->id)) }}" class="btn btn-primary rounded-0">Get Appointment</a>
                    </div>
                </div>
                <div class="col-md-6">
                    {!! $doctor->descriptions !!}
                </div>
            </div>
        </div>
    </div>
@endsection