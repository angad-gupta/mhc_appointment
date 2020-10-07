@extends('mail.layout')

@section('content')
    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">
        Hello {{ $user->name }},
    </p>
    <div style="font-size: 14px; font-weight: 400; line-height: 24px; color: #333333;">
        <p style="font-size:14px;">Verify your e-mail to finish signing up for MEROHEALTHCARE</p>

        <p style="font-size:14px;">Thank you for choosing MEROHEALTHCARE</p>
        <p style="font-size:14px;">Please confirm that {{ $user->email }} is your email address by clicking on the button below within 48 hours. </p>

        <div style="text-align:center;margin:20px">
            <a href="{{ route('patient_verification.verify',$user->activation_code) }}" style="background-color:#2385aa;color:#ffffff;display:inline-block;font-family:Arial, Helvetica, sans-serif;text-transform: uppercase;font-size:14px;font-weight:regular;line-height:30px;text-align:center;text-decoration:none;width:190px;-webkit-text-size-adjust:none;mso-hide:all;border-radius:30px;">Confirm Your Email!</a>
        </div>
        If you did not make this registration, you can ignore this email.

    </div>

    <p style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333">We are coming very soon on <a target="_blank" href="https://www.apple.com/ios/app-store/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#5B9BD5">iOS</a> and <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#5B9BD5" href="https://play.google.com/store/apps?hl=en">Android</a>.</p>
    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">                              
    Regards,<br>
    MEROHEALTHCARE Team
    </p>
@endsection