@extends('front.components.app')

@section('content')

<div class="section-padding login-area-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 my-5">
                <h2 class="text-center">Verify Your Email Address</h2>
                <hr>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a href="{{ route('patient_verification.resend') }}">{{ __('click here to request another') }}</a>.
            </div>
        </div>
    </div>
</div>
@endsection