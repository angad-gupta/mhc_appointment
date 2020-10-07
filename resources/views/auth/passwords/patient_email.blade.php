@extends('front.components.app')

@section('title') Reset Password @endsection

@section('content')
    {{--    <div class="container">--}}
    {{--        <div class="row justify-content-center">--}}
    {{--            <div class="col-md-8">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header">{{ __('Reset Password') }}</div>--}}

    {{--                    <div class="card-body">--}}
    {{--                        @if (session('status'))--}}
    {{--                            <div class="alert alert-success" role="alert">--}}
    {{--                                {{ session('status') }}--}}
    {{--                            </div>--}}
    {{--                        @endif--}}

    {{--                        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">--}}
    {{--                            @csrf--}}

    {{--                            <div class="form-group row">--}}
    {{--                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"--}}
    {{--                                           value="{{ old('email') }}" required>--}}

    {{--                                    @if ($errors->has('email'))--}}
    {{--                                        <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @endif--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="form-group row mb-0">--}}
    {{--                                <div class="col-md-6 offset-md-4">--}}
    {{--                                    <button type="submit" class="btn btn-primary">--}}
    {{--                                        {{ __('Send Password Reset Link') }}--}}
    {{--                                    </button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <style>
        .title span {
            display: block;
            font-size: .9rem;
            line-height: 2.5rem;
            margin-top: -10px;
            font-weight: 300;
        }
        .invalid-feedback{
            display: block;
        }
    </style>
    <div class="login">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3 my-5">


                    <form class="login-form validate" action="{{ route('patient_password.email') }}" method="post">
                        @csrf
                        <h2 class="title pt-4 h2 g-color-black g-font-weight-600">
                            {{ __('website.title_subtitle.reset_password') }}
                            <span>{{ __('website.title_subtitle.reset_password_subtitle') }}</span>
                        </h2>
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                <strong>Success !</strong> {{ session('status') }}

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group pt-4">
                            <label for="exampleInputEmail1">{{ __('website.form.email_address') }}</label>
                            <input type="text" required
                                   class="form-control {{ $errors->has('email') ? ' parsley-error' : '' }}" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('website.form.email_address') }}"/>
                            
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>


                        <button type="submit"
                                class="btn btn-primary rounded-0 pl-5 pr-5 mt-3"> {{ __('website.form.send_password_reset_link') }}</button>

                    </form>
                </div>
                <div class="col-md-6 contact-image"></div>
            </div>
        </div>
        <div class="pb-5"></div>
    </div>
@endsection
