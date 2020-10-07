
  <script src="{{asset('front/assets/vendor/jquery-ui/ui/widgets/datepicker.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.datepicker.js')}}"></script>
<style>
    .ui-datepicker .ui-datepicker-next span {
        font-size: 12px;
    }

    .ui-datepicker .ui-datepicker-prev span {
        font-size: 12px;
    }
</style>
<div class="row">
    <div class="media g-mb-10 g-ml-10">
        <img class="align-self-center g-brd-around g-brd-4 g-brd-white rounded-circle"
            src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}" height="100" width="100"
            alt="{{ $doctor->title }} {{ $doctor->full_name }}">
        <div class="media-body align-self-center">
            <h4 class="h5 g-font-weight-700 g-mb-3 doc-pop-up-name">{{$doctor->title}} {{$doctor->full_name}}
                 {!!$video ? '<i class="fa fa-phone" aria-hidden="true"></i>':''!!}
            </h4>
            <em
                class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 ">{{ $doctor->department->title }}</em>
            <span style="font-size:12px;">
                <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> Medical Registration Verified
            </span>
            @if($video)
                @if($doctor->video_consultation_fee)
                    <h4 class="h6 g-font-weight-300 g-mb-5 g-mt-5">
                        Rs. {{$doctor->video_consultation_fee}} for video consultation
                    </h4>
                @endif
            @else
                @if($doctor->normal_consultation_fee)
                    <h4 class="h6 g-font-weight-300 g-mb-5 g-mt-5">
                        Rs. {{$doctor->normal_consultation_fee}} at clinic
                    </h4>
                @endif
            @endif
           
        </div>
    
    </div>
</div>
<div class="row">    
    <div class="form-group align-self-center g-mt-25 col-md-6" style="
    width: 60%; margin-bottom: -7%;">
        {{-- <input class="form-control align-self-center rounded-50 form-control-md" id="schedule-date-range"> --}}
        <div class="form-group g-mb-50">
            <label class="g-mb-10">Select appointment date</label>
            <div id="datepickerInline" class="u-datepicker-v1 g-brd-gray-light-v2"></div>
        </div>
        <input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctor->id}}">
    </div>
    <div class="col-md-6 mt-5">        
        <div class="text-center appointment-loader" style="font-size:45px;" hidden="">
            <i class="fa fa-cog fa-spin"></i>
        </div>
        <div class="time-message"> 
            <p>Clickable dates denotes doctor is avaibale.</p>
            <p style="margin-top: 80px"><b>Please select the date from calendar to see the time schedule.</b></p>
        </div>
        <div class="schedule-time g-mt-30" hidden="hidden"></div>
        {{-- <div style="margin-top: 210px; margin-left: 300px;">
            <button type="button" class="btn btn-primary confirm-btn" disabled="true">Confirm</button>
        </div> --}}
    </div>
</div>

<script>
    $(function(){

        $('#datepickerInline').datepicker({
            onSelect: function(dateText) {
                $(".confirm-btn").attr('disabled', true);
                $('.appointment-loader').removeAttr("hidden");
                var date = dateText;
                var doctor_id = $('#doctor_id').val();
                var video = $('#video_consultation').val();
                $.ajax({
                    type: "get",
                    url: "{{route('get.schedules')}}",
                    data: {"doctor_id": doctor_id, "date": date,"video":video},
                    success: function(data) {
                        $('.schedule-time').removeAttr('hidden');
                        $('.schedule-time').empty();
                        $('.appointment-loader').attr("hidden","true");
                        $('.time-message').attr("hidden","true");
                        $('.schedule-time').append(data.html);
                    },
                    error:function(data)
                    {
                        
                    }
                });
            },
            minDate: 0,
            beforeShowDay: function(date){
                //scheduleDays received form schedule_scripts
                if ($.inArray(date.getDay(), scheduleDays) != -1) {
                    return [true, ""];
                } else {
                    return [false, ""];
                }
            },
            autoSize: true
        });

        // $("#schedule-date-range").datepicker({
        //     onSelect: function(dateText) {
        //         $('.appointment-loader').removeAttr("hidden");
        //         var date = dateText;
        //         var doctor_id = $('#doctor_id').val();
        //         var video = $('#video_consultation').val();
        //         $.ajax({
        //             type: "get",
        //             url: "{{route('get.schedules')}}",
        //             data: {"doctor_id": doctor_id, "date": date,"video":video},
        //             success: function(data) {
        //                 $('.schedule-time').removeAttr('hidden');
        //                 $('.schedule-time').empty();
        //                 $('.appointment-loader').attr("hidden","true");
        //                 $('.schedule-time').append(data.html);
        //             },
        //             error:function(data)
        //             {
                        
        //             }
        //         });
        //     },
        //     minDate: 0,
        //     beforeShowDay: function(date){
        //         if ($.inArray(date.getDay(), scheduleDays) != -1) {
        //             return [true, ""];
        //         } else {
        //             return [false, ""];
        //         }
        //     }
        // });
    });
</script>