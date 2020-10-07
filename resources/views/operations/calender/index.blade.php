@extends('layouts.app')

@section('css')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('dash/plugins/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
@endsection



@section('content')


    <div class="box-body">
        <div class="row">

            <div class="col-md-12" id="cal">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3" id="eventDetails" style="display: none;">
                <div class="box box-primary">
                    <h2 id="selectedDate" class="text-center">Date and time</h2>
                    <div class="box-body" id="">
                        <div class="list-group" id="selecteddateEvents">
                            <a href="#" class="list-group-item active">
                                <h4 class="list-group-item-heading">List group item heading</h4>
                                <p class="list-group-item-text">...</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>


@endsection

@section('js')
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('dash/plugins/jQueryUI/jquery-ui.min.js') }}"></script>

    <!-- fullCalendar -->
    <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('dash/plugins/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/fullcalendar/dist/locale/bn.js') }}"></script>
    <script src="{{ asset('dash/plugins/fullcalendar/dist/locale-all.js') }}"></script>
    <script>

        var events = [];
        $(function () {
            $('#calendar').fullCalendar({
                locale: '{{ config('app.locale') }}',
                dayClick: function (date) {
                    $("#eventDetails").show();
                    $("#cal").removeClass('col-md-12').addClass('col-md-9');
                    $("#selectedDate").text($.fullCalendar.formatDate(date, 'DD-MM-YYYY'));
                    $.get('/event-by-date/' + $.fullCalendar.formatDate(date, 'D-MM-YYYY'), function (data) {
                        $("#selecteddateEvents").empty();
                        if (data.length != 0) {
                            data.forEach((element) => {
                                var listItemBgColor = '';
                                var listItemColor = '#fff';
                                if (element.status == 0) {
                                    listItemBgColor = "#dd4b39";
                                } else if (element.status == 1) {
                                    listItemBgColor = '#f39c12';
                                    // borderColor = '#f39c12'
                                } else if (element.status == 2) {
                                    listItemBgColor = '#00a65a';
                                    // borderColor = '#00a65a';
                                } else if (element.status == 3) {
                                    listItemBgColor = '#DB4B3F';
                                    // borderColor = '#DB4B3F';
                                } else {
                                    listItemBgColor = '#444';
                                    // borderColor = '#444';
                                }

                                $('#selecteddateEvents').append(
                                    $('<a>', {
                                        href: '/appointment/' + element.encrypted_id,
                                        class: 'list-group-item',
                                        style: 'background-color : ' + listItemBgColor + '; color :' + listItemColor
                                    }).append(
                                        $('<h4>', {
                                            class: 'list-group-item-heading',
                                            text: element.search_id,
                                            style: 'color:' + listItemColor
                                        }).append(
                                            $('<sub>', {class: 'pull-right', text: 'by ' + element.created_by.full_name})
                                        ),
                                        $('<p>', {class: 'list-group-item-text', text: element.schedule_time}),
                                        $('<p>', {class: 'list-group-item-text', text: 'Patient : ' + element.patient.full_name}),
                                        $('<p>', {class: 'list-group-item-text', text: 'Doctor : ' + element.doctor.full_name}),
                                    )
                                )
                            })

                        } else {
                            $('#selecteddateEvents').append(
                                $('<center>', {text: 'No event found'})
                            )
                        }


                        console.log(data);
                    })
                },
                eventLimit: true, // for all non-agenda views
                events: function (start, end, timezone, callback) {
                    $.get('/events?start=' + $.fullCalendar.formatDate(start, 'D-MM-YYYY') + "&end=" + $.fullCalendar.formatDate(end, "D-MM-YYYY"), function (data) {
                        // console.log(data);
                        var events = [];
                        data.forEach((element) => {
                            var bgColor = '';
                            var borderColor = '';
                            if (element.status == 0) {
                                bgColor = '#dd4b39';
                                borderColor = '#dd4b39'
                            } else if (element.status == 1) {
                                bgColor = '#f39c12';
                                borderColor = '#f39c12'
                            } else if (element.status == 2) {
                                bgColor = '#00a65a';
                                borderColor = '#00a65a';
                                console.log('Confirm')
                            } else if (element.status == 3) {

                                bgColor = '#DB4B3F';
                                borderColor = '#DB4B3F';
                            } else {

                                bgColor = '#444';
                                borderColor = '#444';
                            }

                            events.push({
                                title: element.search_id + ' | ' + element.schedule_time,
                                start: element.schedule_date,
                                backgroundColor: bgColor,
                                borderColor: borderColor
                            })
                        });


                        callback(events)
                    });
                }
            });


        })
    </script>
@endsection