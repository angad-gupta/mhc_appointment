<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Super Admin Setup</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <link href=https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css rel=stylesheet>
            <div class="confirm">
                <div class="container-fluid">
                    <i class="ion-ios-checkmark-circle-outline"></i>
                    <h1>Installation Done Successfully</h1>
                    <p>DrAssistant Pro Has been installed successfully. click the button down bellow to start using drassistant pro</p>
                    <form action="{{ route('install.done') }}" method="post">
                        @csrf
                        <button class="btn btn-primary rounded-0">Start Using DrAssistant Pro</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>