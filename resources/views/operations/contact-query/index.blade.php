@extends('layouts.app')

@section('title')
    {{ __('mailbox.mailbox') }}
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('mailbox.mailbox') }}</h3>
        </div>

        <div class="box-body">
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                    <tbody>
                    @forelse($contact_queries as  $contact_query)
                        <tr>
                            <td><input type="checkbox"></td>

                            <td class="mailbox-name">
                                <a href="{{ route('contact-query.show',['id'=> $contact_query->id]) }}">{{ $contact_query->full_name }}</a>
                            </td>
                            <td class="mailbox-subject">
                                <b>{{ str_limit($contact_query->subject, 50 , '...') }}</b>
                                - {{ str_limit($contact_query->message,100,'...') }}
                            </td>

                            <td class="mailbox-date">{{ $contact_query->created_at->diffForHumans() }}</td>
                            <td class="mailbox-attachment">
                                <a href=""><i class="fa fa-reply" aria-hidden="true"></i></a>
                            </td>
                        </tr>

                    @empty
                        <h4>{{ __('mailbox.empty') }}</h4>
                    @endforelse

                    </tbody>
                </table>
            </div>

            <div class="box-footer">
                {!! $contact_queries->links() !!}
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection

