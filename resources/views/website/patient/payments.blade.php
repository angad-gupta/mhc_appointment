
@extends('front.components.app')

@section('title') {{ __('dashboard.dashboard') }} @endsection

@section('content')
    @php
        $payment = \App\Models\PatientPayment::where('patient_id', auth()->user()->patient->id);
        $appointment = \App\Models\Appointment::where('patient_id', auth()->user()->patient->id);
        $prescription = \App\Models\Prescription::where('patient_id', auth()->user()->patient->id);
        $document = \App\Models\PatientMedicalDocument::where('patient_id', auth()->user()->patient->id);
        $note = \App\Models\PatientMedicalNote::where('patient_id', auth()->user()->patient->id);
        $carbon = \Carbon\Carbon::now();
    @endphp
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Payments</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>Payments</span>
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
                <h2 class="h3 u-heading-v1__title">List of payments</h2>
            </div>
                <div class="row pl-4 pr-4">
                    <div class="col-md-12 mb-5">            
                        @include('website.patient.components.payments',['payments'=>$payments])
                        <nav aria-label="Page navigation example ">
                            <ul class="pagination justify-content-center mt-5">
                                {{ $payments->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
    @endsection

   

