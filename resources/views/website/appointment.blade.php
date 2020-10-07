@extends('website.components.app')

@section('title') {{ __('website.nav.get_appointment') }} @endsection

@section('content')
    <div class="page-banner" style="background-image: url('{{ asset('web/images/b8cb9975d682ff9c6c1aa57192db086e.jpg') }}')">
        <h4 class="title text-center pt-4">
            {{ __('website.nav.get_appointment') }}
            <span>{{ __('website.title_subtitle.get_appointment_now_subtitle') }}</span>
        </h4>
    </div>

    @include('website.components.appointment')
@endsection