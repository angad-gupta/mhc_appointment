@extends('front.components.app')

@section('content')
  <style>
    .invalid-feedback{
        display: block;
    }
  </style>

    <div class="login">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3 my-3">
                    <form class="login-form validate" action="{{ url('patient/password/reset') }}" method="post">
                        @csrf
                        <h2 class="title pt-4 h2 g-color-black g-font-weight-600">
                            {{ __('website.title_subtitle.reset_password') }}
                        </h2>
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group pt-4">
                            <label for="exampleInputEmail1">{{ __('website.form.email_address') }}</label>
                            <input type="email" required
                                   class="form-control {{ $errors->has('email') ? ' parsley-error' : '' }}" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('website.form.email_address') }}"/>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('actions.password') }}</label>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('actions.re_type_password') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>


                        <button type="submit"
                                class="btn btn-primary rounded-0 pl-5 pr-5 mt-3"> {{ __('website.title_subtitle.reset_password') }}</button>

                    </form>
                </div>
                <div class="col-md-6 contact-image"></div>
            </div>
        </div>
        <div class="pb-5"></div>
    </div>

@endsection
