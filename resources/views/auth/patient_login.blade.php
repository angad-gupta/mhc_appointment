@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<style>
  .login-social-btn-area {
    margin-top: 30px;
    margin-left: 20px;
    margin-right: 10px
    /* display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between; */
  }
  .login-form .fb-btn {
    background: #3b5998;
    color: #fff;
    width: 100%;
  }
  .login-form .google-btn {
    background: #db4935;
    color: #fff;
    width: 100%;
    margin-top: 5px;
  }
</style>
<section class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall" data-options="{direction: 'reverse', settings_mode_oneelement_max_offset: '150'}">
      <!-- Parallax Image -->
      <div class="divimage dzsparallaxer--target w-100 u-bg-overlay g-bg-size-cover g-bg-bluegray-opacity-0_3--after" style="height: 140%; background-image: url(https://images.unsplash.com/photo-1484711437223-800da6eba762?ixlib=rb-1.2.1&auto=format&fit=crop&w=1328&q=80); transform: translate3d(0px, -214.427px, 0px);"></div>
      <!-- End Parallax Image -->

      <div class="container g-pt-30 g-pb-20">
        <div class="row justify-content-between">
          <div class="col-md-6 flex-md-first align-self-center g-mb-10">
            <div class="mb-5">
              <h1 class="h3 g-color-white g-font-weight-600 mb-3">MEROHEALTHCARE,<br>Online Doctor Video Consulation!</h1>
              <p class="g-color-white-opacity-0_8 g-font-size-12 text-uppercase">Nepal's growing online healthcare partner</p>
            </div>

          </div>
          <div class="col-md-6 col-lg-5 flex-md-unordered align-self-center g-mb-80">
            <div class="g-bg-white rounded g-pa-50">
              <header class="text-center mb-4">
                <h2 class="h2 g-color-black g-font-weight-600">Patient Login</h2>
              </header>
              <!-- Form -->
              <form class="login-form validate" action="{{ route('patient.login') }}" method="post">
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
                
                <div class="text-center">
                  <button class="btn btn-block u-btn-primary rounded g-py-13" type="submit">Login</button>
                  <p class="g-color-gray-dark-v5 mt-10" style="margin-top:10px;">Forgot your password? <a class="g-font-weight-600" href="{{route('patient_password.request')}}">Click Here</a>
                  </p>
                </div>

                <div class="d-flex justify-content-center text-center g-mb-30">
                  <div class="d-inline-block align-self-center g-width-50 g-height-1 g-bg-gray-light-v1"></div>
                  <span class="align-self-center g-color-gray-dark-v5 mx-4">OR</span>
                  <div class="d-inline-block align-self-center g-width-50 g-height-1 g-bg-gray-light-v1"></div>
                </div>
                
                <div class="login-social-btn-area">
                  <div class="row">                    
                    <a href="{{route('social-provider','facebook')}}" class="btn fb-btn btn-block g-py-13"><i class="fa fa-facebook"></i> <span>Login With Facebook</span></a>
                  </div>   
                  <div class="row">
                    <a href="{{route('social-provider','google')}}" class="btn google-btn g-py-13"><i class="fa fa-google"></i> <span>Login With Google</span></a>
                  </div> 
                </div>
              </form>
              <!-- End Form -->
              <footer class="text-center">                
                <div class="col-auto g-px-5 g-pt-5 g-mt-10">
                  <p style="font-weight: 800">Not Registered ?</p>
                  <a href="{{route('register.patient_form')}}" class="btn btn-xl u-btn-orange text-uppercase g-font-weight-600 g-font-size-12 g-rounded-50">Signup</a><br><br>
                </div>
               
              </footer>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    @endsection