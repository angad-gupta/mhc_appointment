@extends('mail.layout')

@section('content')
    <p><b>Your next follow up date : {{ $appointment->next_followup }}</b></p>
    <p>{{ $note }}</p>
@endsection