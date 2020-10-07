@extends('layouts.app')

@section('title')
    Read mail
@endsection

@section('content')

    <style>

        @media print {
            body * {
                visibility: hidden;
            }

            #print * {
                visibility: visible;
            }

        }

    </style>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Maibox</h3>
        </div>

        <div class="box-body">

            <div id="print">
                <div class="table-responsive mailbox-messages">
                    <div class="mailbox-read-info">
                        <h3>{{ $contact_query->subject }}</h3>
                        <h5>From: {{ $contact_query->email_address }}
                            <span class="mailbox-read-time pull-right">{{ $contact_query->created_at->format('dM Y h:g A') }}</span>
                        </h5>
                    </div>

                    <div class="mailbox-read-message">
                        {{ nl2br(e($contact_query->message)) }}
                    </div>
                </div>
            </div>


            <div class="box-footer">
                <div class="pull-right">
                    <a href="{{ route('contact-query.edit',['id'=> $contact_query->id]) }}" class="btn btn-default"><i
                                class="fa fa-reply"></i> Reply</a>
                </div>
                <button onclick="$(this).confirmDelete($('#delete'))" type="button" class="btn btn-default">
                    <i class="fa fa-trash-o"></i> Delete
                </button>

                <button type="button" onclick="window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print
                </button>
            </div>

            <form action="{{ route('contact-query.destroy',['id'=> $contact_query->id]) }}" method="post"
                  id="delete">
                @csrf
                @method('delete')
            </form>

        </div>
    </div>
@endsection

@section('js')

@endsection

