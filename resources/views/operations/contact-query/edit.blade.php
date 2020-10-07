@extends('layouts.app')

@section('title')
    {{ __('mailbox.reply_mail') }}
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('mailbox.reply_mail') }}</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <h4>{{ __('mailbox.replies') }}</h4>
                    <div class="list-group">
                        @forelse($contact_query->replies as $reply)
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">{{ $reply->subject }}</h4>
                                <p class="list-group-item-text">{{ $reply->message }}</p>
                            </a>
                        @empty
                            <a href="#" class="list-group-item">
                                <h4>{{ __('mailbox.no_reply') }}</h4>
                            </a>
                        @endforelse
                    </div>

                </div>
                <div class="col-md-8">
                    <form action="{{ route('contact-query.update',['id'=>$contact_query->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <input class="form-control" value="{{ $contact_query->email_address }}" readonly
                                   placeholder="{{ __('mailbox.form.to') }}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required name="subject" placeholder="{{ __('mailbox.form.subject') }}">
                        </div>
                        <div class="form-group">
                            <textarea id="compose-textarea" required name="message" class="form-control"
                                      placeholder="{{ __('mailbox.form.message') }}"
                                      style="height: 300px"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('mailbox.send_mail') }}</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

