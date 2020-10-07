@extends('front.components.app')

@section('title') {{ __('dashboard.dashboard') }} @endsection

@section('css')
<style>
    .card-body {
        padding: 38px;
        margin-left: -14%;
    }
</style>
@endsection

@section('content')
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Dashboard</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>Dashboard</span>
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
                    <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="{{ asset($patient->photo ? $patient->photo : 'front/assets/images/dummy-user.jpg') }}" alt="{{$patient->full_name}}">
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
                  <span class="btn btn-sm u-btn-primary rounded-0" >{{$patient->full_name}}</span>
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
                <h2 class="h3 u-heading-v1__title">Dashboard</h2>
            </div>
           <div class="row pl-5 pr-4">
                    <div class="col-md-4 mb-4">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $appointment->whereHas('payments')->count() }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('web.patient.appointments') }}">
                                            {{ __('appointment.appointment') }}
                                        </a>
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $prescription->count() }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{route('web.patient.prescriptions')}}">
                                            {{ __('prescription.prescription') }}
                                        </a>
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $appointment->where('next_followup', '!=', null)->count() }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="#">
                                            {{ __('appointment.follow_up') }}
                                        </a>
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $payment->sum('payment_amount') }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{route('web.patient.payments')}}">
                                            {{ __('payment.title') }}
                                        </a> 
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $document->count() }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"> 
                                        <a href="{{route('web.patient.documents')}}">
                                            {{ __('document.document') }}
                                        </a>
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <div class="row no-gutters border">
                            <div class="col-md-4 text-center">
                                <h2 style="line-height: 100px;vertical-align: middle;">{{ $note->count() }}</h2>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{route('web.patient.notes')}}">
                                            {{ __('note.note') }}
                                        </a>
                                    </h5>
                                    {{-- <p class="card-text">
                                        <small class="text-muted">
                                            From the registration
                                        </small>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
          </div>
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
@endsection