<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DrAssistant Install</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">
            <h2 class="title text-center pt-5">DrAssistant Pro Setup Wizard <span>Make sure your server has these php plugins to run DrAssistant Pro.</span>
            </h2>
            <p class="text-center"></p>
            <div class="card mt-5 rounded-0">
                <h4 class="p-2 text-center">Server Requirements</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-check-circle text-success mr-2"></i> PHP {{ phpversion() }}</li>
                    @php
                        $server_requirement_satisfy = true;
                    @endphp

                    @foreach(config('installer.requirements') as $requirement)
                        <li class="list-group-item">
                            @if(extension_loaded($requirement))
                                <i class="fas fa-check-circle text-success mr-2"></i>
                            @else
                                @php
                                    $server_requirement_satisfy = false;
                                @endphp
                                <i class="fas fa-times-circle text-danger mr-2"></i>
                            @endif
                            {{ $requirement }}
                        </li>
                    @endforeach
                </ul>
            </div>
            
                <a href="{{ route('install.personalization') }}" class="btn btn-success rounded-0 mt-4 mb-5 float-right">Install</a>
            
        </div>
    </div>
</div>
<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
</body>
</html>