@extends('mail.layout')

@section('content')
    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">
        Hello {{ $appointment->patient->full_name }},
    </p>

    <div style="font-size: 16px; font-weight: 400; line-height: 24px; color: #333333;">
        {!! $text !!} Please check your account for more details.

        <div style="text-align:center;margin:20px">
            <a href="{{ route('web.patient.appointment',['id'=> encrypt($appointment->id)]) }}" style="background-color:#3eaa23;color:#ffffff;display:inline-block;font-family:cursive;text-transform: uppercase;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;border-radius:30px;">View Appointmemt</a>
        </div>
    </div>

    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">                              
        Regards,<br>
        MEROHEALTHCARE Team
    </p>
@endsection