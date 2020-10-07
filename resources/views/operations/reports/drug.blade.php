@extends('layouts.app')

@section('title') Drug Report @endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{{ __('drug.drug') }} {{ __('drug.report') }}</h2>
        </div>

        <div class="box-body">
            <form action="" method="get" class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">{{ __('drug.select_drug') }}</label>
                        <select name="drug" class="form-control select2">
                            <option value="">{{ __('drug.select_drug') }}</option>
                            @foreach($drugs as $drug)
                                <option {{ setSelectOption(request()->query('drug'),$drug->id) }} value="{{ $drug->id }}">{{ $drug->trade_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">{{ __('appointment.form.date_range') }}</label>
                        <input type="text" value="{{ request()->query('date_range') }}" class="form-control date-range"
                               name="date_range" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2">

                    <div style="margin-top: 24px;">
                        <button type="submit" class="btn btn-success btn-flat btn-block">{{ __('actions.filter') }}</button>
                        <a href="{{ route('report.drug.pdf','drug='.request()->query('drug').'&date_range='.request()->query('date_range')) }}">{{ __('actions.download_pdf') }}</a>
                    </div>
                </div>
            </form>

            <div class="chart">
                <canvas id="myChart" width="100%" height="30px"></canvas>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('dash/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dash/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('dash/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>


    <script>
        $(function () {
            $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="date_range"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
            });

            $('input[name="date_range"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $('.select2').select2();
        });


        var drugs = [];
        var drugUses = [];

        @if(request()->query('drug') == null && request()->query('date_range') == null)
            @foreach($drugs as $drug)
                drugs.push('{{$drug->trade_name}}');
                drugUses.push('{{ \App\Models\PrescriptionDrug::where('name', $drug->trade_name)->count() }}');
            @endforeach
        @endif

        @if(request()->query('drug') != null && request()->query('date_range') != null)
            @php
                $_drug = \App\Models\Drug::find(request()->query('drug'));
                $date_range = explode('to ',request()->query('date_range'));
                $start_date = \Carbon\Carbon::parse($date_range[0])->toDateString();
                $end_date = \Carbon\Carbon::parse($date_range[1])->toDateString();
            @endphp
            drugs.push('{{$_drug->trade_name}}');
            drugUses.push('{{ \App\Models\PrescriptionDrug::where('name', $_drug->trade_name)->whereBetween('created_at', [$start_date,$end_date])->count() }}');
        @endif

        @if(request()->query('drug') != null && request()->query('date_range') == null)
            @php
                $_drug = \App\Models\Drug::find(request()->query('drug'));
            @endphp
            drugs.push('{{$_drug->trade_name}}');
            drugUses.push('{{ \App\Models\PrescriptionDrug::where('name', $_drug->trade_name)->count() }}');
        @endif

        @if(request()->query('drug') == null && request()->query('date_range') != null)
            @php
                $date_range = explode('to ',request()->query('date_range'));
                $start_date = \Carbon\Carbon::parse($date_range[0])->toDateString();
                $end_date = \Carbon\Carbon::parse($date_range[1])->toDateString();
            @endphp
            @foreach($drugs as $drug)
                drugs.push('{{$drug->trade_name}}');
                drugUses.push('{{ \App\Models\PrescriptionDrug::where('name', $drug->trade_name)->whereBetween('created_at', [$start_date,$end_date])->count() }}');
            @endforeach
        @endif



        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: drugs,
                datasets: [{
                    label: '# of Uses',
                    data: drugUses,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>




@endsection