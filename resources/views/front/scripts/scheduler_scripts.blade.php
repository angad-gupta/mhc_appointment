<script src="{{ asset('web/jquery-3.4.1.min.js') }}"></script>

<script>
    var scheduleDays;
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
                scheduleDays = data.scheduleDays;
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

    //   $('body').on('change', '#schedule-date-range', function() {
    //     $('.appointment-loader').removeAttr("hidden");
    //     var date = $(this).val();
    //     var doctor_id = $('#doctor_id').val();
    //     var video = $('#video_consultation').val();
    //      $.ajax({
    //             type: "get",
    //             url: "{{route('get.schedules')}}",
    //             data: {"doctor_id": doctor_id, "date": date,"video":video},
    //             success: function(data) {
    //                 $('.schedule-time').removeAttr('hidden');
    //                 $('.schedule-time').empty();
    //                  $('.appointment-loader').attr("hidden","true");
    //                 $('.schedule-time').append(data.html);
    //             },
    //             error:function(data)
    //             {
                    
    //             }
    //         });
    //   }); 

    });

    $(document).ready(function(){
        $("#filter_button").click(function(){
            $("#filter_div").toggle(500);
        }); 
    });

</script>