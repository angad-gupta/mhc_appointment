@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')


    <div class="g-bg-cover g-bg-pos-top-center g-bg-img-hero g-bg-cover g-bg-black-opacity-0_3--after g-py-150" style="background-image: url(https://images.unsplash.com/photo-1560582861-45078880e48e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80);">
      <div class="container g-pos-rel g-z-index-1">
        <div class="g-mb-20">
          <h1 class="h2 g-color-white mb-0 text-center" style="text-shadow: 3px 5px 6px black;">Search For Doctor</h1>
        </div>

        <div class="g-bg-white-opacity-0_3 g-pa-30 g-pb-0"  style="border-radius: 10px;">
          <!-- Input Group -->
          <form method="GET" action="{{route('w.doctors')}}">
            <div class="row g-mx-0--md">
              <div class="col-md-6 col-lg-8 g-px-0--md g-mb-30">
                <input class="form-control rounded-0 g-brd-gray-light-v3 g-px-20 g-py-15" name="doctor" type="text" placeholder="Doctor name">
              </div>

              <!-- Button Group -->
              <div class="col-sm-6 col-md-3 col-lg-2 g-px-0--md g-mb-30">
                <select class="js-custom-select w-100 u-select-v1 g-min-width-150 g-brd-left-none--md g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-pt-12 g-pb-13" data-placeholder="Choose Department" data-open-icon="fa fa-angle-down" name="department" data-close-icon="fa fa-angle-up">
                  <option></option>
                  @foreach($departments as $d)
                  <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="{{$d->slug}}">{{$d->title}}</option>
                  @endforeach
                </select>
              </div>
              <!-- End Button Group -->

              <div class="col-lg-2 g-px-0--md g-mb-30">
                <button class="btn btn-block u-btn-primary g-color-white g-bg-primary-dark-v1--hover g-font-weight-600 rounded-0 g-px-18 g-py-15" type="submit">
                  Search
                </button>
              </div>
            </div>
          </form>
          <!-- End Input Group -->
        </div>
      </div>
    </div>
    <section class="g-pt-50 g-pb-50">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-lg-4 g-px-40 g-mb-50 g-mb-0--lg">
            <!-- Icon Blocks -->
            <div class="text-center">
              <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                  <i class="icon-science-032 u-line-icon-pro"></i>
                </span>
              <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3">Find a doctor</h3>
              <p class="mb-0">Search doctors according different departments, gender and your fees types. </p>
            </div>
            <!-- End Icon Blocks -->
          </div>

          <div class="col-lg-4 g-brd-left--lg g-brd-gray-light-v4 g-px-40 g-mb-50 g-mb-0--lg">
            <!-- Icon Blocks -->
            <div class="text-center">
              <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                  <i class="icon-note"></i>
                </span>
              <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3">Book Appointment</h3>
              <p class="mb-0">Book your appointment with the available dates and time (Morning, Afternoon and Evening).</p>
            </div>
            <!-- End Icon Blocks -->
          </div>

          <div class="col-lg-4 g-brd-left--lg g-brd-gray-light-v4 g-px-40">
            <!-- Icon Blocks -->
            <div class="text-center">
              <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                  <i class="icon-credit-card"></i>
                </span>
              <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3">Pay</h3>
              <p class="mb-0">Pay through online payments like Khalti ,Esewa.</p>
            </div>
            <!-- End Icon Blocks -->            
          </div>
        </div>
      </div>
          </form>
        </div>
      </div>
    </section>
@endsection

