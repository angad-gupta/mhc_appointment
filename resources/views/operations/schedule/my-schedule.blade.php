@extends('layouts.app')

@section('title')
    {{ __('schedule.my_schedule') }}
@endsection

@section('css')
    <style>
        .not-found {
            min-height: 100px !important;
        }

        .not-found h1 {
            padding-top: 10px !important;
            font-size: 24px;
        }

        .header {
            background-color: gray;
            padding: 7px;
            color: white;
        }

        .header a {
            padding: 15px 0px;
            color: var(--color-primary);
            text-shadow: 2px 2px 2px black;
        }

        .header .header-title small {
            color: inherit;
        }

        .box-body {
            border: 1px solid var(--color-border);
            border-top: transparent;
            height: 250px;
            overflow-y: scroll;
        }
    </style>

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('dash/plugins/timepicker/bootstrap-timepicker.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('schedule.my_schedule') }}</h3>
        </div>
        <div class="row">
            @foreach($schedules as $i=>$schedule)
                <div class="col-md-6">
                    <div class="header">
                        <button class="pull-right btn-primary create-schedule" schedule="{{ $schedule }}"  data-toggle="modal" data-target="#createModal">
                            <i class="fa fa-plus" ></i>
                        </button>
                        {{--<i class="fa fa-info-circle pull-right text-info" data-toggle="modal" data-target="#general_information"></i>--}}
                        <h2 class="header-title">{{ __('calender.days.'.$i) }} -
                            <small>{{ __('schedule.total_schedule') }}</small> {{ $schedule->scheduleDetails->count() }}
                        </h2>
                    </div>
                    <div class="box-body">
                        @if($schedule->scheduleDetails->count() > 0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Schedule</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedule->scheduleDetails->sortBy('start_time') as $key=>$details)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td class="time">{{ date('g:iA',strtotime($details->start_time)) }} - {{ date('g:iA',strtotime($details->end_time)) }}</td>
                                        <td>
                                            <input type="hidden" class="schedule-id" value="{{ encrypt($details->schedule_id) }}">
                                            <input type="hidden" class="detail-id" value="{{ encrypt($details->id) }}">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-success edit-btn" data-toggle="modal" data-target="#editModal">
                                                    <i class="fa  fa-edit"></i>
                                                </button>
                                                <button onclick="$(this).confirmDelete($('#deleteForm{{$i}}{{$key}}'))"
                                                        type="button" class="btn btn-danger"><i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                            <form action="{{ route('delete-schedule',['id'=>encrypt($details->id)]) }}"
                                                  method="post" id="deleteForm{{$i}}{{$key}}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="not-found">
                                <h1>{{ __('actions.nothing_found') }}</h1>
                                <a href="#" class="btn btn-default create-schedule" schedule="{{ $schedule }}" data-toggle="modal" data-target="#createModal">{{ __('schedule.create_schedule') }}</a>
                            </div>
                        @endif
                    </div>
                    <br>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- create modal --}}
    @include('operations.schedule.create')

    {{-- edit modal --}}
    @include('operations.schedule.edit-modal')

@endsection

@section('js')
    <script src="{{ asset('dash/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('.timepicker').timepicker({
                showInputs: false
            })

            $(".create-schedule ").on('click', function(){
                var schedule = $(this).attr('schedule');
                var parsedSchedule = JSON.parse(schedule);
                
                $("#day-index").val(parsedSchedule.day);
                $("#create-schedule-id").val(parsedSchedule.id);//encrypted from controller
            });

            $(".edit-btn").on('click', function(){
                $header = $(this).parents('.col-md-6').find('.header').children('.header-title').text();
                $dayIndex = $header.split("-")[0];
                $("#edit-day-index").val($dayIndex);

                $schedule_id = $(this).parents('td').find('.schedule-id').val();
                $detail_id = $(this).parents('td').find('.detail-id').val();
                $time = $(this).parents('tr').find('.time').text();
                $time = $time.split("-");
               
                $("#start-time").val($time[0]);
                $("#end-time").val($time[1]);
                $("#edit-schedule-id").val($schedule_id);

                $("#update_form").attr('action', '/settings/schedule/'+$detail_id+'/edit');

            });

            // $("#update_form").on('submit', function(){
            //     $("#editModal").modal('hide');
                
            //     setTimeout(function(){
            //         window.location.reload(1);
            //     }, 2000);
            // })
        });
        
    </script>
@endsection