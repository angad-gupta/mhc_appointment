@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<section class="g-bg-secondary">
  <div class="container g-pt-30 g-pb-20">
    <div class="row justify-content-between">
      <div class="col-md-6 col-lg-6 flex-md-unordered align-self-center g-mb-80">
        <div class="u-shadow-v21 g-bg-white rounded g-pa-20">
          <header class="text-center mb-4">
            <h2 class="h2 g-color-black g-font-weight-600">Get Listed</h2>
          </header>

          <!-- Form -->
          <form class="g-py-15">
            <div class="row">
              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Title</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="email" placeholder="Dr">
              </div>

              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Full name</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="tel" placeholder="John Doe">
              </div>
            </div>

            <div class="g-mb-5">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Sex</label>
              <div class="row mb-4" style="margin-left: 0px;">
                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio" checked="">
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Male
                </label>

                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio">
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Female
                </label>

                <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                  <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio">
                  <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                  </div>
                  Other
                </label>
              </div>
            </div>

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Date of birth</label>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <select class="form-control  g-color-black g-bg-white g-bg-white--focus">
                    <option disabled selected>Choose Month</option>
                    <option value="First Option">January</option>
                    <option value="Second Option">February</option>
                    <option value="Third Option">March</option>
                    <option value="Fourth Option">April</option>
                    <option value="Fifth Option">May</option>
                    <option value="Sixth Option">June</option>
                    <option value="Seventh Option">July</option>
                    <option value="Eighth Option">August</option>
                    <option value="Ninth Option">September</option>
                    <option value="Tenth Option">October</option>
                    <option value="Eleventh Option">November</option>
                    <option value="Twelfth Option">December</option>
                  </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                  <input type="number" placeholder="Day" class="form-control  g-color-black g-bg-white g-bg-white--focus">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                  <input type="number" placeholder="Year" class="form-control  g-color-black g-bg-white g-bg-white--focus">
                </div>

              </div>
          
            </div>

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email</label>
              <input
                class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="email" placeholder="johndoe@gmail.com">
            </div>
            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Phone</label>
              <input
                class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="number" placeholder="+9779800000000">
            </div>

            <div class="mb-4">
              <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">NMC Number</label>
              <input name="nmc_number" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                type="text" placeholder="Your NMC Number">
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="password" placeholder="Password">
              </div>

              <div class="col-xs-12 col-sm-6 mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Confirm Password</label>
                <input
                  class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                  type="password" placeholder="Password">
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
                <button class="btn btn-md u-btn-primary rounded g-py-13 g-px-25" type="button">Signup</button>
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

      <div class="col-md-6 col-lg-6 flex-md-first align-self-center g-mb-80">
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