@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
@if (session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif
<section class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall" data-options="{direction: 'reverse', settings_mode_oneelement_max_offset: '150'}">
      <!-- Parallax Image -->
      <div class="divimage dzsparallaxer--target w-100 u-bg-overlay g-bg-size-cover g-bg-bluegray-opacity-0_3--after" style="height: 140%; background-image: url(https://images.unsplash.com/photo-1491314316372-b3ae7000c9ee?ixlib=rb-1.2.1&auto=format&fit=crop&w=1383&q=80); transform: translate3d(0px, -214.427px, 0px);"></div>
      <!-- End Parallax Image -->

      <div class="container g-pt-30 g-pb-20">
        <div class="row justify-content-between">
           <div class="col-md-6 flex-md-first align-self-center g-mb-0">
            <div class="mb-5">
              <h1 class="h3 g-color-white g-font-weight-600 mb-3">Merohealthcare Appointment Admin Login! </h1>

            </div>

           
          </div>
          <div class="col-md-6 col-md-offset-3 col-lg-5 col-lg-offset-3 g-mb-80" >
            <div class="g-bg-white rounded g-pa-50">
              <header class="text-center mb-4">
                <h2 class="h2 g-color-black g-font-weight-600">Admin Login</h2>
              </header>
              <!-- Form -->
                 <form class="login-form validate" action="{{ route('admin.login') }}" method="post">
                        @csrf
                        <div class="form-group pt-4">
                            <label for="exampleInputEmail1">{{ __('website.form.email_address') }}</label>
                            <input type="text" required
                                   class="form-control {{ $errors->has('email') ? ' parsley-error' : '' }}" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('website.form.email_address') }}"/>
                            @if ($errors->has('email'))
                                <ul class="parsley-errors-list filled server-validation">
                                    <li class="parsley-required">{{ $errors->first('email') }}</li>
                                </ul>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('website.form.password') }}</label>
                            <input type="password" required
                                   class="form-control {{ $errors->has('password') ? ' parsley-error' : '' }}"
                                   id="exampleInputPassword1" name="password" placeholder="{{ __('website.form.password') }}"/>
                            @if ($errors->has('password'))
                                <ul class="parsley-errors-list filled server-validation">
                                    <li class="parsley-required">{{ $errors->first('password') }}</li>
                                </ul>
                            @endif
                        </div>
                        <div class="custom-control custom-checkbox" style="padding-left: 0px;padding-bottom: 15px;">
                            <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-12 g-pl-25 mb-0">
                              <input {{ old('remember') ? 'checked' : '' }} name="remember" class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" type="checkbox">
                              <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                <i class="fa" data-check-icon=""></i>
                              </div>
                              Keep signed in
                            </label>
                        </div>
                      <div class="text-center mb-5">
                        <button class="btn btn-block u-btn-primary rounded g-py-13" type="submit">Login</button>
                      </div>
                    </form>
              <!-- End Form -->
              <footer class="text-center">
                <p class="g-color-gray-dark-v5 mb-0">Forgot your password? <a class="g-font-weight-600" href="{{route('password.request')}}">Click Here</a>
                </p>
              </footer>
            </div>
          </div>
         
        </div>
      </div>
    </section>
    @endsection