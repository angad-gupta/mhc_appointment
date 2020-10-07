@if($schedule_count > 0)
  <div style="margin-top: -40px;">
    <p style="font-size: 20px"><i class="fa fa-calendar-times-o" aria-hidden="true"></i>  Pick a time</p>
  </div>
@if(count($morning) > 0)
<div class="row">
    <div class="col-md-4">
      <h3 class="h5 g-font-weight-300"><i class="fa fa-sun-o"></i> Morning</h3>
    </div>
  
  <?php
    if($video)
    {
      $video = true;
    }
    else{
      $video = false;
    }
  ?>
  <div class="col-md-8">
    <div id="shortcode1">
      <div class="shortcode-html">
        <!-- Simple Plain -->
        <ul class="u-list-inline">          
          @foreach($morning as $sd)
            <li class="list-inline-item g-mb-10">
                <button class="u-tags-v1 g-color-main g-brd-around g-brd-gray-light-v3 g-bg-gray-dark-v2--hover g-brd-gray-dark-v2--hover g-color-white--hover g-py-4 g-px-10"
                onClick="makeSelected(this)" schedule_id="{{ $sd->schedule_id }}" start_time="{{ $sd->start_time }}" end_time = "{{ $sd->end_time }}" date="{{ $appointment_date }}" video="{{ $video }}">{{  date('h:i A', strtotime($sd->start_time)) }}</button>
            </li>
          @endforeach 
        </ul>
        <!-- End Simple Plain -->
      </div>
    </div>
  </div> 
</div>
@endif
@if(count($noon) > 0)

<div class="row">
  @if ($noon)
    <div class="col-md-4">
      <h3 class="h5 g-font-weight-300"><i class="fa fa-moon-o"></i> Afternoon</h3>
    </div>
  @endif
  
  <div class="col-md-8">
    <div id="shortcode1">
      <div class="shortcode-html">
        <!-- Simple Plain -->
        <ul class="u-list-inline">          
          @foreach($noon as $sd)
            <li class="list-inline-item g-mb-10">              
                <button class="u-tags-v1 g-color-main g-brd-around g-brd-gray-light-v3 g-bg-gray-dark-v2--hover g-brd-gray-dark-v2--hover g-color-white--hover g-py-4 g-px-10"
                onClick="makeSelected(this)" schedule_id="{{ $sd->schedule_id }}" start_time="{{ $sd->start_time }}" end_time = "{{ $sd->end_time }}" date="{{ $appointment_date }}" video="{{ $video }}">{{ date('h:i A', strtotime($sd->start_time)) }}</button>
            </li>
          @endforeach 
        </ul>
        <!-- End Simple Plain -->
      </div>
    </div>
  </div> 
</div>
@endif

@if(count($evening) > 0)

<div class="row"> 

  <div class="col-md-4">
    <h3 class="h5 g-font-weight-300"><i class="fa fa-moon-o"></i> Evening</h3>
  </div>

  <div class="col-md-8">
    <div id="shortcode1">
      <div class="shortcode-html">
        <!-- Simple Plain -->
        <ul class="u-list-inline">     
          @foreach($evening as $sd)
            <li class="list-inline-item g-mb-10">
                <button  class="u-tags-v1 g-color-main g-brd-around g-brd-gray-light-v3 g-bg-gray-dark-v2--hover g-brd-gray-dark-v2--hover g-color-white--hover g-py-4 g-px-10"
                onClick="makeSelected(this)" schedule_id="{{ $sd->schedule_id }}" start_time="{{ $sd->start_time }}" end_time = "{{ $sd->end_time }}" date="{{ $appointment_date }}" video="{{ $video }}" >{{ date('h:i A', strtotime($sd->start_time)) }}</button>
            </li>
          @endforeach
        </ul>
        <!-- End Simple Plain -->
      </div>
    </div>
  </div>
</div>
@endif
@else
<div class="text-center">
  <h2 class="h3 u-heading-v6__title g-brd-primary">No Appointments found</h2>
</div>
@endif

<div>
  <button type="button" class="btn btn-primary confirm-btn" disabled="true">Confirm</button>
</div>

{{-- <script src="{{ asset('web/jquery-3.4.1.min.js') }}"></script> --}}
<script>

  var start_time, end_time, date, video, schedule_id;

  function makeSelected(ele)
  {
    start_time = $(ele).attr('start_time');
    end_time = $(ele).attr('end_time');
    date = $(ele).attr('date');
    video = $(ele).attr('video');
    schedule_id = $(ele).attr('schedule_id');

    $(".confirm-btn").attr('disabled', false);
  }

  $(document).ready(function(){
    $(".confirm-btn").on('click', function(){
      
      if(video == "" || video == "null" || video == "undefined") {
        video = 1;
      }
      
      window.location = "{{route('start.booking')}}?start_time="+start_time+"&end_time="+end_time+"&date="+date+"&schedule_id="+schedule_id+"&video="+video;
    });

  });

</script>