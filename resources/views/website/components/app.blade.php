<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
    <link rel="icon" href="{{ asset('icon.ico') }}" type="image/x-icon" />

    @php
        $contact = \App\Models\Contact::first();
        $about = \App\Models\About::first()

    @endphp
</head>
<body>

@include('website.components.navbar')

@yield('content')


@include('website.components.footer')

<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
</body>
</html>