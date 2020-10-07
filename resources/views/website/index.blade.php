@extends('website.components.app')

@section('title')
    {{ __('website.nav.home') }}
@endsection


@section('content')

    <div class="main-banner"
         style="background-image: url({{ asset('uploads/website/banner.png') }})">
        <h1>{{ config('app.name') }}</h1>
    </div>

    <div class="featured-doctor clearfix pt-4 pb-5">
        <h1 class="title text-center">{{ __('website.title_subtitle.featured_doctor') }} <span>{{ __('website.title_subtitle.featured_doctor_subtitle') }}</span></h1>
        <div class="container">
            <div class="owl-carousel owl-theme featured-doctor-carousel pt-5">

                @foreach($doctors as $doctor)
                    <div class="card doctor mr-1">
                        <div class="doctor-img">
                            <img src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}"
                                 class="card-img-top" alt="..."/>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->title }} {{ str_limit($doctor->full_name,12,'...') }}
                                <span>{{ $doctor->department->title }}</span></h5>
                            <p class="card-text">
                                {{ $doctor->info }}
                            </p>
                            <a href="{{ route('w.appointment','doctor='.encrypt($doctor->id)) }}"
                               class="btn btn-primary rounded-0">Get Appointment</a>
                            <a href="{{ route('w.doctor.details',['encrypted_id'=> $doctor->slug]) }}"
                               class=" btn btn-link float-right">Learn more <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="clearfix home about-us">

        @if($about)
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-5">
                        <h1 class="title mt-5">{{ __('website.title_subtitle.about_us') }} <span>{{ __('website.title_subtitle.about_us_subtitle') }} </span></h1>
                        <div class="home about-text">
                            <p>{!! nl2br(e($about->about_us )) !!}</p>

                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        @if($about->image_or_video == 2)
                            <div class="embed-responsive embed-responsive-16by9 mt-5">
                                <iframe
                                        class="embed-responsive-item pb-5"
                                        src="{{ $about->about_us_video }}"
                                        allowfullscreen
                                ></iframe>
                            </div>
                        @else
                            <img src="{{ asset($about->about_us_image) }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('website.components.appointment')
@endsection