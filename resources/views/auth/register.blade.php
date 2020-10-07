@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<section class="g-bg-secondary">
  <div class="container g-pt-30 g-pb-20">
    <div class="row justify-content-between">
      <div class="col-md-7 col-lg-7 flex-md-unordered align-self-center g-mb-80">
        <div class="u-shadow-v21 g-bg-white rounded g-pa-20">
          <header class="text-center mb-4">
            <h2 class="h2 g-color-black g-font-weight-600">Get Listed</h2>
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
          <form action="{{route('register.doctors')}}" class="g-py-15" method="POST">
            @csrf
            <div class="row">
              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Title</label>
                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15" type="title" value="{{old('title')}}" placeholder="Dr" name="title">
              </div>

              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Full name</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="text" placeholder="John Doe" value="{{old('full_name')}}" name="full_name">
              </div>
            </div>

            <div class="g-mb-5">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Gender</label>
              <div class="row mb-4" style="margin-left: 0px;">
                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" value="Male" name="sex" type="radio" {{old('sex') == 'Male' ? 'checked' :''}}>
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Male
                </label>

                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" value="Female" name="sex" type="radio" {{old('sex') == 'Female' ? 'checked' :''}}>
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Female
                </label>

                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" value="Others" name="sex" type="radio" {{old('sex') == 'Others' ? 'checked' :''}}>
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Other
                </label>
              </div>
            </div>

           

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email</label>
              <input
                class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="email" value="{{old('email')}}" name="email" placeholder="johndoe@gmail.com">
            </div>
            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Departments</label>
              <select class="form-control g-color-black g-bg-white g-bg-white--focus" name="department_id">
                <option disabled selected>Choose Department</option>
                @foreach($departments as $d)
                <option {{old('department_id') == $d->id ? 'selected' : ''}} value="{{$d->id}}">{{$d->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Phone</label>
              <input
                class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="number" name="phone_number" value="{{old('phone_number')}}" placeholder="9800000000">
            </div>

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">NMC Number</label>
              <input name="nmc_number" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="text" name="nmc_number" value="{{old('nmc_number')}}" placeholder="Your NMC Number">
            </div>

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Qualification</label>
              <textarea name="qualification" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
              placeholder="Your qualification">{{old('qualification')}}</textarea>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="password" placeholder="Password" name="password">
              </div>

              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Confirm Password</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="password" placeholder="Password" name="password_confirmation">
              </div>
            </div>

            <div class="row justify-content-between mb-5">
              <div class="col-8 align-self-center">
                <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-13 g-pl-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" type="checkbox">
                  <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                    <i class="fa" data-check-icon=""></i>
                  </div>
                  I accept the <a href="#!">Terms and Conditions</a>
                </label>
              </div>
              <div class="col-4 align-self-center text-right">
                <button class="btn btn-md u-btn-primary rounded g-py-13 g-px-25" type="submit">Signup</button>
              </div>
            </div>
          </form>
          <!-- End Form -->

          <footer class="text-center">
            <p class="g-color-gray-dark-v5 mb-0">Already listed? <a class="g-font-weight-600"
                href="{{route('login')}}">Login</a>
            </p>
          </footer>
        </div>
      </div>

      <div class="col-md-5 col-lg-5 flex-md-first g-mb-80 g-mt-20">
        <div class="mb-5">
          <h1 class="h3 g-font-weight-600 mb-3">Profitable contracts,<br>invoices &amp; payments for the best cases!
          </h1>
          <p class="g-color-gray-dark-v5 g-font-size-12 text-uppercase">Trusted by 31,000+ users globally</p>
        </div>

        <div class="row">
          <div class="col-md-11 col-lg-9">
            <!-- Icon Blocks -->
            <div class="media mb-4">
              <div class="d-flex mr-4">
                <span class="align-self-center u-icon-v1 u-icon-size--lg g-color-primary">
                  <i class="icon-finance-168 u-line-icon-pro"></i>
                </span>
              </div>
              <div class="media-body align-self-center">
                <p class="g-color-gray-dark-v5 mb-0">Reliable contracts, multifanctionality &amp; best usage of Unify
                  template</p>
              </div>
            </div>
            <!-- End Icon Blocks -->

            <!-- Icon Blocks -->
            <div class="media mb-5">
              <div class="d-flex mr-4">
                <span class="align-self-center u-icon-v1 u-icon-size--lg g-color-primary">
                  <i class="icon-finance-193 u-line-icon-pro"></i>
                </span>
              </div>
              <div class="media-body align-self-center">
                <p class="g-color-gray-dark-v5 mb-0">Secure &amp; integrated options to create individual &amp; business
                  websites</p>
              </div>
            </div>
            <!-- End Icon Blocks -->

            <!-- Testimonials -->
            <blockquote class="u-blockquote-v1 g-color-gray-dark-v5 rounded g-pl-60 g-pr-30 g-py-25 g-mb-40">Look no
              further you came to the right place. Unify offers everything you have dreamed of in one package.
            </blockquote>
            <div class="media">
              <img class="d-flex align-self-center rounded-circle g-width-40 g-height-40 mr-3"
                src="../../assets/img-temp/100x100/img12.jpg" alt="Image Description">
              <div class="media-body align-self-center">
                <h4 class="h6 g-font-weight-600 g-mb-0">Alex Pottorf</h4>
                <em class="g-color-gray-dark-v5 g-font-style-normal g-font-size-12">Web Developer</em>
              </div>
            </div>
            <!-- End Testimonials -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection