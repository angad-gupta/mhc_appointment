
@extends('front.components.app')

@section('title') {{ __('dashboard.dashboard') }} @endsection

@section('content')
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Account Settings</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>Account Settings</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
    <section class="g-mb-100 g-pt-50">
      <div class="container">
        <div class="row">
          <!-- Profile Sidebar -->
          <div class="col-lg-3 g-mb-50 g-mb-0--lg">
            <!-- User Image -->
            <div class="u-block-hover g-pos-rel">
                   <figure>              
                <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="{{ asset(auth()->user()->patient->photo ? auth()->user()->patient->photo : 'front/assets/images/dummy-user.jpg') }}" alt="{{auth()->user()->patient->full_name}}">
              </figure>

              <!-- Figure Caption -->
              <figcaption class="u-block-hover__additional--fade g-bg-black-opacity-0_5 g-pa-30">
                <div class="u-block-hover__additional--fade u-block-hover__additional--fade-up g-flex-middle">
                  <!-- Figure Social Icons -->
                  <ul class="list-inline text-center g-flex-middle-item--bottom g-mb-20">
                    <li class="list-inline-item align-middle g-mx-7">
                      <a class="u-icon-v1 u-icon-size--md g-color-white" href="{{route('web.patient.setting')}}">
                        <i class="icon-note u-line-icon-pro"></i>
                      </a>
                    </li>
                  </ul>
                  <!-- End Figure Social Icons -->
                </div>
              </figcaption>
              <!-- End Figure Caption -->

              <!-- User Info -->
              <span class="g-pos-abs g-top-20 g-left-0">
                  <span class="btn btn-sm u-btn-primary rounded-0" >{{auth()->user()->patient->full_name}}</span>
                </span>
              <!-- End User Info -->
            </div>
            <!-- User Image -->

            <!-- Sidebar Navigation -->
            @include('website.components.side-nav')
            <!-- End Sidebar Navigation -->
          </div>
          <!-- End Profile Sidebar -->
          <!-- Profle Content -->
          <div class="col-lg-9">
          @include('website.components.video_call_notification')
          <div class="u-heading-v1-4 g-bg-main g-brd-gray-light-v2 g-mb-20">
                <h2 class="h3 u-heading-v1__title">Account Settings</h2>
            </div>
              @if(session()->has('update_password'))
                            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                <strong>{{ __('actions.success') }}!</strong> {{ session('update_password') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                            @if(session()->has('update_email'))
                            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                <strong>{{ __('actions.success') }}!</strong> {{ session('update_email') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                            @if(session()->has('update_username'))
                            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                <strong>{{ __('actions.success') }}</strong> {{ session('update_username') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
<ul class="nav nav-justified u-nav-v2-1 u-nav-primary u-nav-rounded-5 g-mb-20" role="tablist" data-target="nav-2-1-accordion-primary-hor-justified" data-tabs-mobile-type="accordion" data-btn-classes="btn btn-md btn-block u-btn-outline-primary g-mb-20">
<li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#nav-2-1-accordion-primary-hor-justified--4" role="tab">My Account</a>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#nav-2-1-accordion-primary-hor-justified--1" role="tab">Change Username</a>
  </li> --}}
  {{-- <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#nav-2-1-accordion-primary-hor-justified--2" role="tab">Change Email</a>
  </li> --}}
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#nav-2-1-accordion-primary-hor-justified--3" role="tab">Change Password</a>
  </li>
</ul>
<!-- End Nav tabs -->

<!-- Tab panes -->
<div id="nav-2-1-accordion-primary-hor-justified" class="tab-content">
 <div class="tab-pane fade show active" id="nav-2-1-accordion-primary-hor-justified--4" role="tabpanel">
              @if(session()->has('account_update'))
                                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <strong>{{ __('actions.success') }}</strong> {{ session('account_update') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
            @include('website.patient.components.user_profile_form')
  </div>
  {{-- <div class="tab-pane fade" id="nav-2-1-accordion-primary-hor-justified--1" role="tabpanel">
      <form class="validate" action="{{ route('update.username','red=true') }}" method="post">
                            @csrf
                            <h5 class="mt-5"><i class="fa fa-key"></i> {{ __('settings.change_user_name') }}</h5>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('settings.account_setup.new_user_name') }}</label>
                                <input type="text" required class="form-control" value="{{auth()->user()->user_name}}" name="user_name" placeholder="{{ __('settings.account_setup.new_user_name') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ __('settings.account_setup.current_password') }}</label>
                                <input type="password" required class="form-control" name="current_password" placeholder="{{ __('settings.account_setup.current_password') }}"/>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-0">{{ __('actions.submit') }}</button>
                        </form>
  </div> --}}
  {{-- <div class="tab-pane fade" id="nav-2-1-accordion-primary-hor-justified--2" role="tabpanel">
     <form method="post" action="{{ route('update.email','red=true') }}" class="validate">
                            @csrf
                            <h5 class="mt-5"><i class="fa fa-envelope"></i> {{ __('settings.account_setup.change_email') }}</h5>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('settings.account_setup.new_email') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="{{ __('settings.account_setup.new_email') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ __('settings.account_setup.current_password') }}</label>
                                <input type="password" class="form-control" name="current_password" required placeholder="{{ __('settings.account_setup.current_password') }}"/>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-0">{{ __('actions.submit') }}</button>
                        </form>

                    
  </div> --}}
                      <div class="tab-pane fade" id="nav-2-1-accordion-primary-hor-justified--3" role="tabpanel">
                          <form class="validate" method="post" action="{{ route('patient.update.password','red=true') }}">
                            @csrf

                            
                                <div class="form-group">
                                    <label for="">{{ __('settings.account_setup.current_password') }}</label>
                                    <input type="password" required name="current_password" class="form-control">
                                </div>
                            
                            
                                <div class="form-group">
                                    <label for="">{{ __('settings.account_setup.new_password') }}</label>
                                    <input type="password" minlength="4" id="password" required name="password" class="form-control">
                                </div>
                            
                            
                                <div class="form-group">
                                    <label for="">{{ __('settings.account_setup.re_type_new_password') }}</label>
                                    <input type="password" required name="password_confirmation" data-parsley-equalto="#password"
                                           class="form-control">
                                </div>
                            
                            
                                <button type="submit" class="btn btn-primary rounded-0 mt-4">{{ __('actions.submit') }}</button>
                            </div>
                        </form>

                      
                      </div>

</div>
<!-- End Tab panes -->
       
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
    @endsection

   



