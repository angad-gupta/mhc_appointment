@extends('front.components.app')

@section('title')
{{ __('website.nav.home') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')


<section class="g-pt-50 g-pb-90" >
    <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <!-- User Block -->
            <div class="g-brd-around g-brd-gray-light-v4 g-pa-20 g-mb-40" style="border-radius: 10px;">
              <div class="row">
                <div class="col">
                  <!-- User Details -->
                  <div class="d-flex align-items-center justify-content-sm-between g-mb-5">
                    <h2 class="g-font-weight-300 g-mr-10">{{ $doctor->title }} {{ $doctor->full_name }}</h2>
                      <img class="g-height-90 g-width-90 rounded-circle g-mr-5" src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}" alt="{{ $doctor->title }} {{ $doctor->full_name }}">
                  </div>

                  <!-- End User Details -->

                  <!-- User Position -->
                    <h4 class="h6 g-font-weight-300 g-mb-10">
                      <span class="u-label g-bg-primary g-rounded-3"><i class="icon-badge g-pos-rel g-top-1 g-mr-5"></i> {{ $doctor->department->title }}</span>
                    </h4>
                  <!-- End User Position -->
                  

                  <!-- User Info -->
                  <ul class="list-inline g-font-weight-300">
                    @if($doctor->doctor_status == 'approved')
                    <li class="list-inline-item g-mr-20" style="color: green">
                      <i class="icon-check g-pos-rel g-top-1 g-mr-5"></i> Verified Doctor
                    </li>
                    @endif
                    @if($doctor->video_consultation_fee)
                    <li class="list-inline-item g-mr-20" style="color: #2383aa;">
                      <i class="fa fa-money g-pos-rel g-top-1 g-mr-5"></i>NPR. {{$doctor->video_consultation_fee}}
                    </li>
                    @else
                    <li class="list-inline-item g-mr-20" style="color: #2383aa;"> 
                      <i class="fa fa-money g-pos-rel g-top-1 g-mr-5"></i>NPR. 300
                    </li>
                    @endif
                    @if($doctor->experience)
                    <li class="list-inline-item g-mr-20" style="color: #e81c62">
                      <i class="fa fa-history"></i> {{$doctor->experience}} years experience
                    </li>
                    @endif
                  </ul>
                  <!-- End User Info -->
                    
                  @if($doctor->info)
                  <hr class="g-brd-gray-light-v4 g-my-20">

                 {!! $doctor->info !!}
                 @endif
                   @if($doctor->descriptions)
                  <hr class="g-brd-gray-light-v4 g-my-20">

                 {!! $doctor->descriptions !!}
                 @endif
                  {{-- <div class="g-mb-15">
                    <span class="js-rating g-color-primary mr-2" data-rating="5">
                        <div class="g-rating" style="display: inline-block; position: relative; z-index: 1; white-space: nowrap; margin-left: -2px; margin-right: -2px;">
                            <div class="g-rating-forward" style="position: absolute; left: 0px; top: 0px; height: 100%; overflow: hidden; width: 100%;">
                                <i class="fa fa-star" style="margin-left: 2px; margin-right: 2px;"></i>
                                <i class="fa fa-star" style="margin-left: 2px; margin-right: 2px;"></i>
                                <i class="fa fa-star" style="margin-left: 2px; margin-right: 2px;"></i>
                                <i class="fa fa-star" style="margin-left: 2px; margin-right: 2px;"></i>
                                <i class="fa fa-star" style="margin-left: 2px; margin-right: 2px;"></i>
                            </div>
                        <div class="g-rating-backward" style="position: relative; z-index: 1;">
                            <i class="fa fa-star-o" style="margin-left: 2px; margin-right: 2px;"></i>
                            <i class="fa fa-star-o" style="margin-left: 2px; margin-right: 2px;"></i>
                            <i class="fa fa-star-o" style="margin-left: 2px; margin-right: 2px;"></i>
                            <i class="fa fa-star-o" style="margin-left: 2px; margin-right: 2px;"></i>
                            <i class="fa fa-star-o" style="margin-left: 2px; margin-right: 2px;"></i>
                        </div>
                    </div>
                    </span>
                    <span class="g-color-gray-dark-v5">Rating 5.0 out of 4902 reviews</span>
                  </div> --}}
                  @if($doctor->services)

                  <hr class="g-brd-gray-light-v4 g-my-20">

                  <div class="g-mb-15">
                    <h2 class="h6 text-uppercase g-color-gray-dark-v1" style="margin-left:10px;">Services</h2>
                      <?php
                        $services = explode(',',$doctor->services);
                      ?>
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
            
                </div>
              </div>
            </div>
            <!-- End User Block -->
     </div>
        
        <div class="col-lg-5">
        <div class="card border-0 rounded-0 g-mb-50">
              <!-- Panel Header -->
              <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15" style="border-radius: 10px;">
                <h3 class="h6 mb-0" >
                    <i class="icon-layers g-pos-rel g-top-1 g-mr-5"></i> Appointment Time
                  </h3>
              </div>
              <div class="row">
                <div class="container">
                  {{-- <input class="form-control align-self-center rounded-50 form-control-md" value="{{\Carbon\Carbon::today()->toDateString()}}" type="date" id="schedule-date-range">
                  <input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctor->id}}"> --}}
                  <label for="">{{ __('appointment.form.select_date') }} <span class="text-danger">*</span></label>
                  <input required name="schedule_date" type="text" id="schedule-date-range" class="form-control"
                          autocomplete="off"
                          placeholder="{{ __('appointment.form.select_date') }}">
                  <input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctor->id}}">
                </div>
              </div>
              <div class="text-center appointment-loader" style="font-size:45px;" hidden="">
    <i class="fa fa-cog fa-spin"></i>
</div>
<div class="schedule-time g-mt-45">
  {{-- schedule time --}}
</div>

</div>
</div>
</div>
</section>


@endsection

@section('js')
{{-- <script src="{{ asset('web/jquery-3.4.1.min.js') }}"></script> --}}
<script src="{{ asset('dash/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(function () {
       $('.book-appointment').click(function(){
         $('#appointment-date-picker-loader').removeAttr("hidden");
        var id = $(this).attr("cid");
        $('#video_consultation').val('false');
        $.ajax({
                type: "get",
                url: "{{route('get.doctor')}}",
                data: {"doctor_id": id},
                success: function(data) {
                    $('#appointment_date_picker').empty();
                    $('#appointment_date_picker').append(data.html);
                    $('#appointment-date-picker-loader').attr("hidden","true");
                },
                error:function(data)
                {
                    alert("Server error");
                    $('#appointment-date-picker-loader').attr("hidden","true");
                }
            });
       
      });

      $('.video-consultation').click(function(){
         $('#appointment-date-picker-loader').removeAttr("hidden");
        var id = $(this).attr("cid");
        $('#video_consultation').val('true');
        $.ajax({
                type: "get",
                url: "{{route('get.doctor')}}",
                data: {"doctor_id": id,"video_consultation" : true},
                success: function(data) {
                    $('#appointment_date_picker').empty();
                    $('#appointment_date_picker').append(data.html);
                    $('#appointment-date-picker-loader').attr("hidden","true");
                },
                error:function(data)
                {
                    alert("Server error");
                    $('#appointment-date-picker-loader').attr("hidden","true");
                }
            });
       
      });

      // $('body').on('change', '#schedule-date-range', function() {
      //   $('.appointment-loader').removeAttr("hidden");
      //   var date = $(this).val();
      //   var doctor_id = $('#doctor_id').val();
      //   var video = $('#video_consultation').val();
      //    $.ajax({
      //           type: "get",
      //           url: "{{route('get.schedules')}}",
      //           data: {"doctor_id": doctor_id, "date": date,"video":video},
      //           success: function(data) {
      //               $('.schedule-time').removeAttr('hidden');
      //               $('.schedule-time').empty();
      //                $('.appointment-loader').attr("hidden","true");
      //               $('.schedule-time').append(data.html);
      //           },
      //           error:function(data)
      //           {
                    
      //           }
      //       });
      // });


              $.ajax({
                type: "get",
                url: "{{route('get.doctor')}}",
                data: {"doctor_id": $('#doctor_id').val(),"video_consultation" : true},
                success: function(data) {
                    scheduleDays = data.scheduleDays;
                    var disableDate = [];                    
                    $('#schedule-date-range').datepicker({
                        startDate: '1d',
                        autoclose: true,
                        format: 'dd-M-yyyy',
                        orientation: 'bottom',
                        beforeShowDay: function(date){
                                    //scheduleDays received form schedule_scripts
                                    if ($.inArray(date.getDay(), scheduleDays) == -1) {
                                        if($.inArray(date.getDay(), disableDate) == -1){
                                            return false;
                                        }
                                    }
                                },
                    }).on('change', function () {
                      $('.appointment-loader').removeAttr("hidden");
                      var date = $(this).val();
                      var doctor_id = $('#doctor_id').val();
                      var video = $('#video_consultation').val();
                      $.ajax({
                              type: "get",
                              url: "{{route('get.schedules')}}",
                              data: {"doctor_id": doctor_id, "date": date,"video":video},
                              success: function(data) {
                                console.log(data);
                                  $('.schedule-time').removeAttr('hidden');
                                  $('.schedule-time').empty();
                                  $('.appointment-loader').attr("hidden","true");
                                  $('.schedule-time').append(data.html);
                              },
                              error:function(data)
                              {
                                  
                              }
                          });
                    });

                },
                error:function(data)
                {
                    alert("Server error");
                }
            });
  
    });
</script>
    
@endsection

