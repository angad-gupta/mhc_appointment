@extends('mail.layout')

@section('content')
    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">
        Hello {{ $name }},
    </p>

    <div style="font-size: 16px; font-weight: 400; line-height: 24px; color: #333333;">
        You are receiving this email because we received a password reset request for your user account.

        <div style="text-align:center;margin:20px">
            <a href="{{ route('patient_password.reset', $token) }}" style="background-color:#3eaa23;color:#ffffff;display:inline-block;font-family:cursive;text-transform: uppercase;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;border-radius:30px;">Reset Password</a>
        </div>
        If you did not request a password reset, no further action is required.
    </div>

    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333">We are coming very soon on <a target="_blank" href="https://www.apple.com/ios/app-store/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#5B9BD5">iOS</a> and <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#5B9BD5" href="https://play.google.com/store/apps?hl=en">Android</a>.</p>
    <p style="font-size: 14px; font-weight: 600; line-height: 24px; color: #333333;">                              
        Regards,<br>
        MEROHEALTHCARE Team
    </p>
@endsection