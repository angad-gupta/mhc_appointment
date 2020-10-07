@extends('layouts.app')

@section('title')
    {{ $doctor->title }} {{ $doctor->full_name }} - Detials
@endsection

@section('css')
    <style>
        .img {
            height: 400px;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $doctor->title }} {{ $doctor->full_name }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="img">
                        <img src="{{ asset($doctor->photo ? $doctor->photo : 'dash/img/boxed-bg.jpg') }}" alt=""
                             class="img-responsive">
                    </div>

                    <dl class="dl-horizontal">
                        <dt>Gender</dt>
                        <dd>{{ ucwords($doctor->sex) }}</dd>
                        <dt>{{ __('doctor.phone') }}</dt>
                        <dd>{{ $doctor->phone }}</dd>
                        <dt>{{ __('department.department') }}</dt>                        
                        <dd>{{ $doctor->department->title }}</dd>
                         <dt>Qualification</dt>
                        <dd>{{ $doctor->qualification }}</dd>
                             <dt>Experience (in years)</dt>
                        <dd>{{ $doctor->experience }}</dd>
                        <dt>NMC Number</dt>
                        <dd>{{ $doctor->nmc_number }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    {!! $doctor->descriptions !!}
                </div>
            </div>
        </div>
        @admin
        <div class="box-footer">
            <div class="btn-group pull-right">
                <a href="{{ route('doctor.edit',['id'=>encrypt($doctor->id)]) }}" class="btn btn-primary"><i
                            class="fa fa-pencil-square-o"></i> {{ __('actions.edit') }} </a>
                <button onclick="$(this).confirmDelete($('#deleteDoctor'))" class="btn btn-danger"><i
                            class="fa fa-trash"></i> {{ __('actions.delete') }}
                </button>
            </div>
            <form action="{{ route('doctor.destroy',['id'=>encrypt($doctor->id)]) }}" method="post" id="deleteDoctor">
                @csrf
                @method('delete')
            </form>
        </div>
        @endadmin
    </div>
@endsection

@section('js')

@endsection

