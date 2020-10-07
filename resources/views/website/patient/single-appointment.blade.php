
@extends('front.components.app')

@section('title') {{ __('dashboard.dashboard') }} @endsection

@section('content')
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Appointment Details</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
            <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{route('web.patient.appointments')}}">Appointments</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>{{$appointment->search_id}}</span>
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
                <h2 class="h3 u-heading-v1__title">Appointment Details</h2>
            </div>
            <div class="row">
            
    <div class="col-md-8 media g-mb-10">
        <img class="align-self-center g-brd-around g-brd-4 g-brd-white rounded-circle" src="{{ asset($appointment->doctor->photo ? $appointment->doctor->photo : 'web/images/avatar.png') }}" height="100" width="100" alt="{{$appointment->doctor->full_name}}">
        <div class="media-body align-self-center" style="cursor:pointer;">
        <a class="g-color-secondary--hover" style="text-decoration:none;" href="{{route('w.doctor.details',$appointment->doctor->slug)}}">
            <h4 class="h5 g-font-weight-700 g-mb-3 doc-pop-up-name">{{$appointment->doctor->title}}. {{$appointment->doctor->full_name}}                 
            </h4>
          </a>
            <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 ">{{$appointment->doctor->department->title}}</em>  
            <span style="font-size:14px;">
                <i class="fa fa-calendar-check-o g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> {{$appointment->search_id}}
            </span>                                               
            
        </div>
    
    </div>
    @php
      $videoCall = \App\Models\VideoCall::where('appointment_id', $appointment->id)->first();
    @endphp

    @if ($videoCall && $videoCall->status)        
      <div class="col-md-4">
        <a class="btn btn-primary" style="float: right; cursor: pointer; margin-top: 30px;" href="{{route('join.patient_room',Session::get('video_call_status'))}}" target="_blank"><i class="fa fa-flask g-mr-2"></i> Join Call</a>
      </div>
    @endif
</div>
                    <div class="row pl-4 pr-4">
                    <div class="col-md-12">
                        <ul class="nav nav-pills justify-content-center mb-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a
                                        class="nav-link rounded-0 active"
                                        id="home-tab"
                                        data-toggle="tab"
                                        href="#prescription"
                                        role="tab"
                                        aria-controls="home"
                                        aria-selected="true"
                                >{{ __('prescription.prescription') }}</a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-0"
                                        id="profile-tab"
                                        data-toggle="tab"
                                        href="#document"
                                        role="tab"
                                        aria-controls="profile"
                                        aria-selected="false">{{ __('document.document') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-0"
                                        id="contact-tab"
                                        data-toggle="tab"
                                        href="#note"
                                        role="tab"
                                        aria-controls="contact"
                                        aria-selected="false">{{ __('note.note') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-0"
                                        id="contact-tab"
                                        data-toggle="tab"
                                        href="#payment"
                                        role="tab"
                                        aria-controls="contact"
                                        aria-selected="false">{{ __('payment.title') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="prescription" role="tabpanel"
                                 aria-labelledby="home-tab">
                                @include('website.patient.components.prescriptions',['prescriptions'=>$appointment->prescriptions])
                            </div>
                            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="profile-tab">
                                @include('website.patient.components.documents', ['documents'=> $appointment->documents])
                            </div>
                            <div class="tab-pane fade" id="note" role="tabpanel" aria-labelledby="contact-tab">
                                @include('website.patient.components.note', ['notes'=>$appointment->notes])
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="contact-tab">
                                @include('website.patient.components.payments', ['payments'=>$appointment->payments])
                            </div>
                        </div>
                    </div>
                </div>
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
    @endsection

   


