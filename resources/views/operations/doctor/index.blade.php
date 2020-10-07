@extends('layouts.app')

@section('title')
    {{ __('doctor.all_doctor') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/css/animate.css') }}">
    <style>

    </style>
@endsection



@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('doctor.all_doctor') }}</h3>
        </div>

        <div class="box-body">
            <form action="{{ route('doctor.index') }}" method="get" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __('website.form.search_doctor') }}" value="{{ request()->query('q') }}" name="q" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-8">
                        <div class="form-group">
                            <select name="order" id="" class="form-control">
                                <option {{ request()->query('order') == 'asc' ? 'selected' : '' }} value="asc">A - Z</option>
                                <option {{ request()->query('order') == 'desc' ? 'selected' : '' }} value="desc">Z- A</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-4">
                        <button type="submit" class="btn btn-primary btn-flat">{{ __('actions.filter') }}</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @forelse($doctors as $key=>$doctor)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="card-box animated fadeInRight">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="doc-img">
                                            <img src="{{ asset($doctor->user->photo ? asset($doctor->user->photo) : 'dash/img/avatar2.png') }}" alt="">
                                        </div>
                                        <a href="#">
                                            @if($doctor->user->status == 1)
                                                <div class="account-status ac-active">
                                                    <span><i class="fa fa-check"></i> <b>{{ __('actions.active') }}</b></span>
                                                </div>
                                            @else
                                                <div class="account-status ac-inactive">
                                                    <span><i class="fa fa-close"></i> <b>{{ __('actions.inactive') }}</b></span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <h3 class="card-title">
                                            <small>{{ $doctor->title }} </small>{{ $doctor->full_name }}</h3>
                                        <p class="text-success"><b>{{ $doctor->department->title }}</b></p>
                                        <p>
                                            {{ str_limit($doctor->info,120) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group btn-group-justified btn-flat">
                                        <a href="{{ route('doctor.show',['id'=>encrypt($doctor->id)]) }}" class="btn btn-success btn-flat"><i
                                                    class="fa fa-eye"></i></a>
                                        @admin
                                        <a href="{{ route('doctor.edit',['id'=>encrypt($doctor->id)]) }}"
                                           class="btn btn-info btn-flat"
                                           title="{{ __('doctor.edit_doctor') }}"><i class="fa fa-edit"></i></a>
                                            <a onclick="$(this).confirmDelete($('#doctorDelete{{$key}}'))" href="javascript:void(0)" class="btn btn-danger btn-flat"
                                            title="{{ __('doctor.delete_doctor') }}"><i class="fa fa-trash"></i></a>
                                            <a
                                            class="btn btn-info btn-success"
                                            title="Approve Doctor" onclick="$(this).confirmApprove($('#doctorApprove{{$key}}'))"><i class="fa fa-check"></i></a>
                                            <a
                                           class="btn btn-info btn-danger"
                                           title="Reject Doctor" onclick="$(this).confirmReject($('#doctorReject{{$key}}'))"><i class="fa fa-ban"></i></a>
                                        @endadmin
                                    </div>
                                    <form action="{{ route('doctor.destroy',['id'=>encrypt($doctor->id)]) }}" id="doctorDelete{{$key}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                      <form action="{{ route('doctor.approve',['id'=>encrypt($doctor->id)]) }}" id="doctorApprove{{$key}}" method="post">
                                        @csrf
                                    </form>
                                       <form action="{{ route('doctor.reject',['id'=>encrypt($doctor->id)]) }}" id="doctorReject{{$key}}" method="post">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="not-found">
                        <h1>No Doctor Found</h1>
                        <a href="{{ route('doctor.create') }}">Create a doctor</a>
                    </div>

                @endforelse


            </div>
            <div class="row">
                <center>
                    {{ $doctors->links() }}
                </center>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$.fn.confirmApprove = function (formId) {
        swal({
            title: "Are you sure?",
            text: "Approving a doctor will result into him getting access on his dashboard and status will be active",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                console.log(formId);
                formId.submit();
                if ($.uploadPreview) {
                    $("#image-preview").css('background-image', "url('../../img/boxed-bg.jpg')");
                }
            } else {
                swal("Your data is safe!");
            }
        });
    };
    $.fn.confirmReject = function (formId) {
        swal({
            title: "Are you sure?",
            text: "Rejecting a doctor will result into him not showing up in the system and status will be in-active",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                console.log(formId);
                formId.submit();
                if ($.uploadPreview) {
                    $("#image-preview").css('background-image', "url('../../img/boxed-bg.jpg')");
                }
            } else {
                swal("Your data is safe!");
            }
        });
    };
</script>
@endsection

