{{-- 

@extends('website.components.app')

@section('title') {{ __('website.nav.account.my_account') }} @endsection

@section('content')
    <div class="page-banner"
         style="background-image: url('{{ asset('web/images/b8cb9975d682ff9c6c1aa57192db086e.jpg') }}')">
        <h4 class="title text-center pt-4">
            {{ __('website.nav.account.my_account') }}
        </h4>
    </div>

    <div class="container-fluid dashboard">
        <div class="row">
            <div class="col-md-2 pl-0 pr-0 left-sidebar">
                @include('website.components.sidebar')
            </div>
            <div class="col-md-10 pl-0">
                <div class="border-bottom d-title mb-5">
                    <h4 class="ml-4">{{ __('website.nav.account.my_account') }}</h4>
                </div>
                <form action="{{ route('web.patient.update-account') }}" method="post" class="validate"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row pl-4 pr-4">
                        <div class="col-md-4">
                            <label for="uploadImage" class="image" style="background-image: url({{ asset(auth()->user()->patient->photo) }}); background-size: cover;" >
                                <input type="file" id="uploadImage" name="photo" class="uploadPreview"/>
                                <span>{{ __('admin.admin_photo') }}</span>
                            </label>
                        </div>

                        <div class="col-md-8">
                            <div class="form-row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="title"
                                               value="{{ auth()->user()->patient->title }}"
                                               placeholder="{{ __('patient.title') }}"/>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="full_name"
                                               value="{{ auth()->user()->patient->full_name }}"
                                               placeholder="{{ __('doctor.full_name') }}"/>
                                    </div>
                                </div>

                                <div class="col-4 col-md-2">
                                    <div class="form-group">
                                        <select name="sex" required class="form-control">
                                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Male') }} value="Male">
                                                Male
                                            </option>
                                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Female') }} value="Female">
                                                Female
                                            </option>
                                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Other') }} value="Other">
                                                Other
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 col-md-5">
                                    <div class="form-group">
                                        <input type="text"
                                               value="{{ \Carbon\Carbon::parse(auth()->user()->patient->date_of_birth)->format('d-M-Y') }}"
                                               required name="date_of_birth"
                                               class="form-control date_of_birth"
                                               placeholder="{{ __('patient.birth_date') }}"/>
                                    </div>
                                </div>
                                <div class="col-4 col-md-5">
                                    <div class="form-group">
                                        <input type="text" required class="form-control"
                                               readonly
                                               value="{{ auth()->user()->patient->age }}"
                                               placeholder="{{ __('patient.age') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="{{ auth()->user()->patient->occupation }}"
                                               class="form-control" name="occupation"
                                               placeholder="{{ __('patient.occupation') }}"/></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="{{ auth()->user()->patient->height }}"
                                               class="form-control" name="height"
                                               placeholder="{{ __('patient.height') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="{{ auth()->user()->patient->weight }}"
                                               class="form-control"
                                               name="weight"
                                               placeholder="{{ __('patient.weight') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" required class="form-control"
                                               value="{{ auth()->user()->patient->cell_phone }}"
                                               name="cell_phone"
                                               placeholder="{{ __('patient.home_phone') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               value="{{ auth()->user()->patient->home_phone }}"
                                               name="home_phone"
                                               placeholder="{{ __('patient.cell_phone') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" readonly class="form-control"
                                               placeholder="{{ __('patient.contact_email') }}"
                                               name="contact_email"
                                               value="{{ auth()->user()->patient->contact_email }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               placeholder="{{ __('patient.country') }}"
                                               name="country"
                                               value="{{ auth()->user()->patient->country }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               value="{{ auth()->user()->patient->city }}"
                                               name="city"
                                               placeholder="{{ __('patient.city') }}"/></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="address" rows="5" class="form-control"
                                                  placeholder="{{ __('patient.address') }}"
                                                  value="{{ auth()->user()->patient->address }}"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary rounded-0">{{ __('actions.submit') }}</button>
                                </div>
                            </div>

                            @if(session()->has('account_update'))
                                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <strong>{{ __('actions.success') }}</strong> {{ session('account_update') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}


@extends('front.components.app')

@section('title') {{ __('dashboard.dashboard') }} @endsection

@section('content')
<style>
.dashboard .image {
    height: 400px;
    width: 100%;
    background-color: grey;
    position: relative;
    cursor: pointer;
}
</style>
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">My Account</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>My Account</span>
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
                <h2 class="h3 u-heading-v1__title">My Account</h2>
            </div>
              @if(session()->has('account_update'))
                                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <strong>{{ __('actions.success') }}</strong> {{ session('account_update') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
            @include('website.patient.components.user_profile_form')
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
    @endsection

