@extends('layouts.app')

@section('title')
    {{ __('admin.all_admin') }}
@endsection

@section('css')
    <style>
        .admin-photo {
            height: 200px;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.all_admin') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                @foreach($admins as $key=>$admin)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="card-box animated fadeInRight">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="admin-photo">
                                            <img src="{{ asset($admin->photo ? $admin->photo : 'dash/img/boxed-bg.jpg') }}"
                                                 class="img-responsive" alt="">
                                        </div>

                                        <a href="#">
                                            @if($admin->status == 1)
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
                                        <h4 class="card-title" title="{{ $admin->full_name }}">
                                            {{ str_limit($admin->full_name,20,'..') }}</h4>
                                        <br>
                                        <p>
                                        <dl class="">
                                            <dt>{{ __('actions.email') }}</dt>
                                            <dd>{{ $admin->email }}</dd>
                                            <dt>{{ __('actions.user_name') }}</dt>
                                            <dd>{{ $admin->user_name }}</dd>
                                        </dl>
                                        </p>
                                    </div>
                                </div>
                                @if(auth()->user()->id == 1)
                                    @if($admin->id != 1)
                                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                            <a href="{{ route('admin.edit',['id'=>encrypt($admin->id)]) }}"
                                               class="btn btn-success btn-flat" title="{{ __('admin.edit_admin') }}"><i
                                                        class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.show', ['id'=> encrypt($admin->id)]) }}" class="btn btn-info btn-flat"><i
                                                        class="fa fa-eye"></i></a>
                                            <a href="javascript:void(0)"
                                               onclick="$(this).confirmDelete($('#deleteAdmin{{$key}}'))"
                                               class="btn btn-danger btn-flat" title="{{ __('admin.delete_admin') }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        <form action="{{ route('admin.destroy',['id'=>encrypt($admin->id)]) }}" method="post"
                                              id="deleteAdmin{{$key}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <center>
                    {{ $admins->links() }}
                </center>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

