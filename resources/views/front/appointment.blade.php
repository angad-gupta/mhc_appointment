@extends('front.components.app')

@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')

<section class="g-pt-50 g-pb-90">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 g-pr-40--lg g-mb-50 g-mb-0--lg">
        <!-- Categories -->
        <h2 class="h5 text-uppercase g-color-gray-dark-v1">Specialities</h2>
        <div class="list-group list-group-border-0 g-mb-40">
              @foreach($departments as $d)
              <a href="{{route('w.department',$d->slug)}}" class="@if(isset($department_slug)){{$department_slug == $d->slug ? 'active' :''}}@else {{Request::get('department') == $d->slug  ? 'active' :''}} @endif list-group-item list-group-item-action justify-content-between">
                <span>{{$d->title}}</span>
              </a>
              @endforeach
            </div>
        <!-- End Categories -->

        {{-- <!-- Tags -->
        <h2 class="h5 text-uppercase g-color-gray-dark-v1">Availability</h2>
        <hr class="g-brd-gray-light-v4 g-my-15">
        <div class="btn-group justified-content g-mb-40">
          <label class="u-check">
            <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radGroupBtn1_1" type="radio">
            <span
              class="btn btn-block g-font-size-11 u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0">
              Today</span>
          </label>
          <label class="u-check">
            <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radGroupBtn1_1" type="radio">
            <span
              class="btn btn-block g-font-size-11 u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">Tomorrow</span>
          </label>
          <label class="u-check">
            <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radGroupBtn1_1" type="radio">
            <span
              class="btn btn-block g-font-size-11 u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">Next
              7 Days</span>
          </label>
        </div>
        <!-- End Tags --> --}}

        <!-- Result Types -->
       
        
        <!-- End Result Types -->
      </div>
      <!-- End Sidebar -->

      <!-- Search Results -->
      <div class="col-lg-9">
        <!-- Search Info -->
        <div class="d-md-flex justify-content-between g-mb-30">
                     
                <h3 class="h6 text-uppercase g-mb-10 g-mb--lg">About <span
                class="g-color-gray-dark-v1">{{$doctors->total()}}</span> results</h3>        
           
          <ul class="list-inline">
            <li class="list-inline-item g-mr-30">
              <a class="u-link-v5 g-color-gray-dark-v1 g-color-primary--hover" href="javascript:;" id="filter_button">
                <i class="fa fa-search g-pos-rel g-top-0 g-mr-5"></i> Filter
              </a>
            </li>
          </ul>
        </div>
        <!-- End Search Info -->
      <div class="container g-pos-rel g-z-index-1" id="filter_div"   @if($doctors->total() > 0)style="display:none;" @endif>
        <!-- Input Group -->
        <form method="GET" action="{{route('w.doctors')}}">
             <div class="row justify-content-center">
               <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="department" data-placeholder="Department" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
                <option></option>
               @foreach($departments as $d)
                  <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="{{$d->slug}}">{{$d->title}}</option>
                @endforeach
              </select>
              <!-- End Button Group -->
            </div>
            <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="gender" data-placeholder="Gender" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
                <option></option>
                <option  class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Any">Any</option>
                <option  class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Male">Male</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Female">Female</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Other">Other</option>
              </select>
              <!-- End Button Group -->
            </div>

            <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="consultation_fee" data-placeholder="Consultation Fee" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
                <option></option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="free">Free</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="300">NPR.1-300</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="500">NPR.300-500</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="1000">NPR.500-1000</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="1000+">NPR.1000+</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Any">Any</option>
              </select>
              <!-- End Button Group -->
            </div>
            
          </div>
          <div class="row justify-content-center g-mx-5--md">
            <div class="col-sm-9 col-lg-7 g-px-0--sm g-mb-30">
              <input name="doctor" class="form-control rounded-0 g-brd-gray-light-v3 g-px-20 g-py-15" type="text" placeholder="Search by Doctor name">
            </div>

            <div class="col-sm-3 col-lg-2 g-px-0--sm g-mb-30">
              <button class="btn btn-block u-btn-primary g-color-white g-bg-primary-dark-v1--hover g-font-weight-600 rounded-0 g-px-18 g-py-15" type="submit">
                Search
              </button>
            </div>
          </div>
        </form>
        <!-- End Input Group -->
      </div>
    
        @if($doctors->total() > 0)
        <div class="row">
          @foreach($doctors as $doctor)
              <div class="col-lg-6 g-mb-30">
                <!-- Search Result -->
                <article class="g-pa-25 u-shadow-v11 rounded" style="min-height:300px; background-color: #d2d0d0;">
                  <h2 class="h4 g-mb-15">
                    <div class="row">
                      <i class="icon-check g-pos-rel g-top-1" style="text-shadow: -1px 0 	#228B22, 0 1px 		#228B22, 1px 0 		#228B22, 0 -1px		#228B22; color: 	#228B22; margin-left:90%"></i>
                    </div>
                    <div class="row">                     
                      <img class="g-height-150 g-width-150 rounded-circle mx-auto"
                      src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}"
                      alt="{{ $doctor->title }} {{ $doctor->full_name }}">
                    </div>
                    <div class="row">
                      <a class="u-link-v5 g-color-gray-dark-v1 g-color-primary--hover mx-auto" href="{{route('w.doctor.details',$doctor->slug)}}" title="{{ $doctor->title}} {{ $doctor->full_name }}">
                        <p>{{ $doctor->title }}. {{ $doctor->full_name }}</p>
                      </a>
                    </div>
                    {{-- <ul class="text-center list-inline d-flex justify-content-between g-mb-5">
                      <li class="list-inline-item g-mr-20"> --}}
                        <p class="text-center u-link-v5 g-color-main g-font-size-14 g-color-primary--hover"
                          id="doc-department-{{$doctor->id}}" href="#!"
                          title="{{ $doctor->department->title }}">{{ $doctor->department->title }}</p>
                      {{-- </li>
                    </ul> --}}
                    <h4 class="text-center h6 g-font-weight-300">
                      @if($doctor->video_consultation_fee)
                        NPR. {{$doctor->video_consultation_fee}} per Appointment
                      @else
                        NPR. 300 per Appointment
                      @endif
                    </h4>
                  </h2>
                  <hr style="border-top: 2px solid;">
                  @if($doctor->services)
                  <?php
                    $services = explode(',',$doctor->services);
                  ?>
                  <div class="g-mb-20">
                    @foreach($services as $key => $val)
                    @if($key <= 4) <span class="u-label u-label--sm g-bg-gray-light-v4 g-color-main g-rounded-20 g-px-10">
                      {{$val}}</span>
                      @endif
                      @endforeach
                      @if(count($services) >= 4)
                      <div class="text-center">
                        <a href="{{route('w.doctor.details',$doctor->slug)}}" class="g-font-size-12">View All({{count($services)}})</a>
                      </div>
                      @endif
                  </div>
                  @endif
    
                  @if($doctor->experience)
                  <h4 class="h6 g-font-weight-300" style="margin-top: -15px; margin-bottom: -30px;">
                    {{-- <i class="fa fa-history g-pos-rel g-top-1 g-mr-5 g-color-gray-dark-v5"></i>  --}}
                          {{$doctor->experience}} years experience overall 
                  </h4>
                  @else
                  <h4 class="h6 g-font-weight-300" style="margin-top: -15px; margin-bottom: -30px;">
                    &nbsp;
                  </h4>
                  @endif
                  @if($doctor->location)
                  <h4 class="h6 g-font-weight-300 g-mb-10">
                          <i class="fa fa-map-marker g-pos-rel g-top-1 g-mr-5 g-color-gray-dark-v5"></i> {{$doctor->location}} 
                  </h4>
                  @endif
                  {{-- <div class="media row" style="margin-left: 16px; margin-top: 40px;"> --}}
                    <div class="row"  style="margin-left: 1px; margin-top: 35px;">
                      <div class="d-flex g-mr-10">
                        <span class="u-icon-v3 u-icon-size--xs g-bg-purple g-color-white g-rounded-50x">
                          <i class="fa fa-calendar-check-o"></i>
                        </span>
                      </div>
                      @if(availableToday($doctor->id))
                      <div class="media-body">
                        <p class="m-1"><strong>Available Today</strong></p>
                      </div>
                      @elseif(availableTomorrow($doctor->id))
                      <div class="media-body">
                        <p class="m-1"><strong>Available Tomorrow</strong></p>
                      </div>
                      @elseif(availableSevenDays($doctor->id))
                      <div class="media-body">
                        <p class="m-1"><strong>Available within next 7 days</strong></p>
                      </div>
                      @else
                      <div class="media-body">
                        <p class="m-1"><strong>Not Available for next 7 days</strong></p>
                      </div>
                      @endif
                    </div>
                    <div class="row" style="margin-left: 3px; margin-bottom: 10px; width: 96%; margin-top: 10px;">
                      <a class="btn btn-block g-bg-purple left" href="{{route('w.doctor.details',$doctor->slug)}}">
                        <span style="color: #f7f7f7; font-weight: 100%;">View Profile</span> 
                      </a>
                    </div>
                    <div class="row" style="margin-left: 3px;
                    margin-bottom: 10px;
                    width: 96%;
                    margin-top: 10px;">
                      <a class="btn btn-block g-bg-purple video-consultation" data-toggle="modal" cid="{{$doctor->id}}" data-target="#exampleModal"href="#!">
                        <i class="fa fa-video-camera g-pos-rel g-top-1 g-mr-5"></i><span style="color: #f7f7f7; font-weight: 100%;">Book Video Consultation</span>
                      </a>
                    </div>
                  {{-- </div>               --}}
                  <!-- Share, Print and More -->
                  {{-- <ul class="list-inline mb-0">
                    <li class="list-inline-item g-mr-20">
                      <a href="javascript:;" data-toggle="modal" cid={{$doctor->id}} data-target="#exampleModal" class="book-appointment btn btn-sm u-btn-primary g-mr-10 g-mb-15"><i
                          class="fa fa-credit-card g-pos-rel g-top-1 g-mr-5"></i>Book Appointment</a>
                    </li>
                    @if($doctor->video_consultation == 1)
                    <li class="list-inline-item g-mr-20">
                      <a href="javascript:;" data-toggle="modal" cid="{{$doctor->id}}" data-target="#exampleModal" class="video-consultation btn btn-sm u-btn-primary g-mr-10 g-mb-15"><i
                          class="fa fa-video-camera g-pos-rel g-top-1 g-mr-5"></i>Video Consultation</a>
                    </li>
                    @endif
                  </ul> --}}
                  <!-- End Share, Print and More -->
                </article>
                <!-- End Search Result -->
              </div>
            @include('front.components.appointment')
          @endforeach
        </div>
        <hr class="g-brd-gray-light-v4 g-mt-10 g-mb-40">

        <!-- Pagination -->
        <nav class="g-mb-50" aria-label="Page Navigation">
          {{$doctors->appends(request()->input())->links()}}
        </nav>
        <!-- End Pagination -->

        @else
        <div class="row justify-content-center ">
          <h2>No Doctors found</h2>
        </div>
        @endif
      </div>
      <!-- End Search Results -->
    </div>
  </div>
</section>

@include('front.scripts.scheduler_scripts')

@endsection

