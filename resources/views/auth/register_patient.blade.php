@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<style>
  .login-social-btn-area {
    margin: 30px 0;
  }
  .fb-btn, .fb-btn:hover {
    background: #3b5998;
    color: #fff;
  }
  .google-btn, .google-btn:hover {
    background: #db4935;
    color: #fff;
  }
</style>
<section class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall" data-options="{direction: 'reverse', settings_mode_oneelement_max_offset: '150'}">
      <!-- Parallax Image -->
      <div class="divimage dzsparallaxer--target w-100 u-bg-overlay g-bg-size-cover g-bg-bluegray-opacity-0_3--after" style="height: 140%; background-image: url(https://images.unsplash.com/photo-1507646278763-8b57d6bf6369?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80); transform: translate3d(0px, -214.427px, 0px);"></div>
      <!-- End Parallax Image -->

      <div class="container g-pt-30 g-pb-20">
        <div class="row justify-content-between">
          <div class="col-md-4 flex-md-first align-self-center g-mb-10">
            <div class="mb-5">
              <h1 class="h3 g-color-white g-font-weight-600 mb-3">MEROHEALTHCARE,<br>Online Doctor Video Consulation!</h1>
              <p class="g-color-white-opacity-0_8 g-font-size-12 text-uppercase">Nepal's growing online healthcare partner</p>
            </div>

            <div class="row">
              <div class="col-md-11 col-lg-9">
                
               
                <!-- End Testimonials -->
              </div>
            </div>
          </div>
          <div class="col-md-8 col-lg-8 flex-md-unordered align-self-center g-mb-80">
            <div class="g-bg-white rounded g-pa-50">
              <header class="text-center mb-4">
                <h2 class="h2 g-color-black g-font-weight-600">Patient Signup</h2>
              </header>
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show d-flex" role="alert">
                  <span class="check-icon"><i class="icofont icofont-close"></i></span>
                  <div class="g-px-15">
                      <h4 class="mt-0"> Oops! Correct the following errors</h4>
                      <ul class="mb-0 p-0">
                          @foreach ($errors->all() as $error)
                          <li>{!! $error !!}</li>
                          @endforeach
                      </ul>
                  </div>
                  <button type="button" class="close" data-dismiss="alert">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @endif
              <!-- Form -->
              <form class="validate" method="post" action="{{route('register.patients')}}">
                @csrf
                  <div class="form-row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="">{{ __('website.form.full_name') }}</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Full name of the user" required
                          class="form-control {{ $errors->has('full_name') ? ' parsley-error' : '' }}" />
                  
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">Gender</label>
                        <select name="gender" required class="form-control {{ $errors->has('gender') ? ' parsley-error' : '' }}">
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Others">Others</option>
                        </select>
                  
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">{{ __('patient.birth_date') }}</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="off"
                          class="form-control date_of_birth {{ $errors->has('date_of_birth') ? ' parsley-error' : '' }}" />
                  
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">{{ __('patient.cell_phone') }}</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required
                          class="form-control {{ $errors->has('phone_number') ? ' parsley-error' : '' }}" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <h5>{{ __('actions.account_information') }}</h5>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">{{ __('actions.email') }}</label>
                        <input type="email" name="email" required
                          class="form-control {{ $errors->has('email') ? ' parsley-error' : '' }}" value="{{ old('email') }}" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">{{ __('actions.password') }}</label>
                        <input type="password" name="password" required
                          class="form-control {{ $errors->has('password') ? ' parsley-error' : '' }}" />
                      </div>
                    </div>
                    <div class="col-md-6 repass">
                      <div class="form-group">
                        <label for="">{{ __('actions.re_type_password') }}</label>
                        <input type="password" name="password_confirmation"
                          class="form-control {{ $errors->has('password_confirmation') ? ' parsley-error' : '' }}" />
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <div class="custom-control custom-checkbox">
                        <label class="form-check-label g-mb-20">
                            <input type="checkbox" name="terms_of_use" class="form-check-input" {{ old('terms_of_use') ? 'checked' : '' }}/>
                          </label>
                        <label class="custom-control-label" for="registerCheck">I agree with terms and conditions</label>
                      </div>
                    </div>
                  </div>

                  <div class="text-center" style="margin-top: 10px;">
                    <div class="text-center mb-5">
                      <button class="btn btn-block u-btn-primary rounded g-py-13" type="submit">Register</button>
                    </div>

                  </div>
                  <hr>
                  <h3 class="h5 text-center">OR,</h3>
                  <div class="login-social-btn-area text-center">
                    <div class="">
                      <a href="{{route('social-provider','facebook')}}" class="btn fb-btn "><i class="fa fa-facebook"></i> &nbsp;<span>Login With Facebook</span></a>
                    </div>   
                    <div class="row">
                      {{-- <a href="{{route('social-provider','google')}}" class="btn google-btn btn-block"><i class="fa fa-google"></i> &nbsp;<span>Login With Google</span></a> --}}
                    </div>                 
                  </div>
              </form>
              <!-- End Form -->
              <footer class="text-center">
                <p class="g-color-gray-dark-v5 mb-0">Already have an account? <a class="g-font-weight-600" href="{{route('patient.login')}}">Click Here</a>
                </p>
              </footer>
            </div>
          </div>
         
        </div>
      </div>
    </section>
    @endsection