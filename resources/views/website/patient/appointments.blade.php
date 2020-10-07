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
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Appointments</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>Appointments</span>
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
                <h2 class="h3 u-heading-v1__title">List of Appointments</h2>
            </div>
              <div class="row pl-4 pr-4">
                    <div class="col-md-12 mb-5">
                        <form action="{{ route('web.patient.appointments') }}" class="input-group mb-3 shadow-sm">
                            <input type="text" value="{{ request()->query('search') }}" name="search"
                                   class="form-control" placeholder="{{ __('appointment.appointment') }}"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary rounded-0" type="submit" id="button-addon2">
                                    {{ __('website.form.search') }}
                                </button>
                            </div>
                        </form>

                        <div class="list-group alternative">
                            @forelse($appointments as $appointment)
                                <a href="{{ route('web.patient.appointment',['id'=>encrypt($appointment->id)]) }}"
                                   class="list-group-item list-group-item-action">
                                    <div class="row">
                                      <div class="col-md-9">
                                        <h4 class="h5 g-mb-5"><i class="fa fa-user-md"></i> {{ $appointment->doctor->title . ' ' . $appointment->doctor->full_name }}</h4>
                                      </div>
                                      <div class="col-md-3">
                                        <small style="margin-left: 50px;">{{ \Carbon\Carbon::parse($appointment->schedule_date)->format('d-M-Y l') }} </small>
                                      </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            @switch($appointment->status)
                                                @case(0)
                                                <i class="fa fa-ban text-danger" data-toggle="tooltip" data-title="Appointment Cancelled"></i>
                                                @break

                                                @case(1)
                                                <i class="fa fa-hourglass-start text-warning" data-toggle="tooltip" data-title="Appointment Pending"></i>
                                                @break

                                                @case(2)
                                                <i class="fa fa-check-circle text-primary" data-toggle="tooltip" data-title="Appointment Complete"></i>
                                                @break

                                                @case(3)
                                                <i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Appointment Confirmed"></i>
                                                @break

                                                @case(4)
                                                <i class="fa fa-user-clock text-primary" data-toggle="tooltip" data-title="Appointment on process"></i>
                                                @break

                                                @default

                                            @endswitch
                                            <strong data-toggle="tooltip" data-title="Appointment ID">{{ $appointment->search_id }}</strong>
                                        </h5>

                                        @php
                                            $time = explode('To', $appointment->schedule_time);
                                        @endphp

                                      <small>{{ date('h:i A', strtotime($time[0])) }} - {{ date('h:i A', strtotime($time[1])) }}</small>

                                        {{-- <small>{{ \Carbon\Carbon::parse($appointment->schedule_date)->format('d-M-Y l') }} </small> --}}
                                    </div>

                                
                                    <div class="d-block">
                                      <span class="g-color-cyan g-font-size-default g-mr-3">
                                          <i class="fa fa-hospital-o"></i>
                                      </span>
                                      <em class="g-color-gray-dark-v4 g-font-style-normal g-font-size-default">{{ $appointment->doctor->department->title }}</em>
                                      
                                      @php
                                        $videoCalls = \App\Models\VideoCall::where('appointment_id', $appointment->id)->get();
                                      @endphp

                                      {{-- only display join call button, if respective appointment has started --}}
                                      @foreach ($videoCalls as $videoCall)
                                        @if ($videoCall->status)
                                          @php
                                              $url = route('join.patient_room',Session::get('video_call_status'));
                                          @endphp
                                          <button class="btn btn-primary" onclick="event.preventDefault();window.open('{{ $url }}', '_blank');" style="float: right; cursor: pointer; margin-right: 10px;"><i class="fa fa-flask g-mr-2"></i> Join Call</button>
                                        @endif   
                                      @endforeach
                                                                                                                   
                                    </div>
                                    @if($appointment->created_by)
                                      <small>Created by : {{ $appointment->createdBy->full_name }}</small>
                                    @endif
                                </a>
                            @empty

                                <h4 class="text-center">Appointment Not Found</h4>

                            @endforelse
                        </div>
                        <nav aria-label="Page navigation example ">
                            <ul class="pagination justify-content-center mt-5">
                                {{ $appointments->appends(request()->all())->links() }}
                            </ul>
                        </nav>

                    </div>
                </div>
          <!-- End Profle Content -->
        </div>
      </div>
    </section>
    @endsection