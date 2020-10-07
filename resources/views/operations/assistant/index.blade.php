@extends('layouts.app')

@section('title')
    {{ __('assistant.all_assistant') }}
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
            <h3 class="box-title">{{ __('assistant.all_assistant') }}</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('assistant.index') }}" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control" placeholder="{{ __('website.form.search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="order" class="form-control">
                                <option value="asc">A - Z</option>
                                <option value="desc">Z- A</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-flat">{{ __('actions.filter') }}</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @forelse($assistants as $key=>$assistant)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="card-box animated fadeInRight">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="admin-photo">
                                            <img src="{{ asset($assistant->photo ? $assistant->photo : 'dash/img/boxed-bg.jpg') }}"
                                                 class="img-responsive" alt="">
                                        </div>

                                        <a href="#">
                                            @if($assistant->user->status == 1)
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
                                        <h4 class="card-title" title="{{ $assistant->full_name }}">
                                            {{ str_limit($assistant->full_name,20,'..') }}</h4>
                                        <br>
                                        <p>
                                        <dl class="">
                                            <dt>{{ __('actions.email') }}</dt>
                                            <dd>{{ $assistant->user->email }}</dd>
                                            <dt>{{ __('actions.user_name') }}</dt>
                                            <dd>{{ $assistant->user->user_name }}</dd>
                                        </dl>
                                        </p>
                                    </div>
                                </div>
                                @if(auth()->user()->id == 1)

                                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <a href="{{ route('assistant.edit',['id'=>encrypt($assistant->id)]) }}"
                                           class="btn btn-success btn-flat" title="{{ __('admin.edit_admin') }}"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="{{ route('assistant.edit', ['id'=> encrypt($assistant->id)]) }}"
                                           class="btn btn-info btn-flat"><i
                                                    class="fa fa-eye"></i></a>
                                        <a href="javascript:void(0)"
                                           onclick="$(this).confirmDelete($('#deleteAdmin{{$key}}'))"
                                           class="btn btn-danger btn-flat" title="{{ __('admin.delete_admin') }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('assistant.destroy',['id'=>encrypt($assistant->id)]) }}" method="post"
                                          id="deleteAdmin{{$key}}">
                                        @csrf
                                        @method('delete')
                                    </form>

                                @endif
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="not-found">
                        <h1>{{ __('actions.nothing_found') }}</h1>
                        <a href="{{ route('doctor.create') }}">{{ __('assistant.create_assistant') }}</a>
                    </div>

                @endforelse
            </div>
            <div class="row">
                <center>
                    {{ $assistants->links() }}
                </center>
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection

