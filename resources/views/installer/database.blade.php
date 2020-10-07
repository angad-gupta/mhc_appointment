<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Database Setup</title>
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">

            <p class="text-center"></p>
            <form action="{{ route('install.database') }}" method="post" class="validate">
                @csrf
                <div class="card mt-5">
                    <h4 class="text-center pt-4">Database Setup</h4>
                    <div class="pt-2 pl-4 pr-4 pb-3">
                        <div class="form-group">
                            <label for="">Database Host</label>
                            <input type="text" name="db_host"
                                   value="{{ old('db_host') ? old('db_host') : '127.0.0.1' }}" required
                                   placeholder="Default : 127.0.0.1"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Database Port</label>
                            <input type="text" name="db_port" value="{{ old('db_port') ? old('db_port') : '3306' }}"
                                   required
                                   placeholder="Default : 3306"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Database Name</label>
                            <input type="text" name="db_name" value="{{ old('db_name') }}" required
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Database User Name</label>
                            <input type="text" name="db_user_name" value="{{ old('db_user_name') }}" required
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Database Password</label>
                            <input type="password" name="db_password" value="{{ old('db_password') }}" required
                                   class="form-control">
                        </div>
                    </div>
                </div>

                @if(config('installer.steps.database'))
                    <p>It's look like you already setup your database with db name
                        <code>{{ config('database.connections.mysql.database') }}</code>. <a
                                href="{{ route('install.mail') }}" class="btn btn-link">Skip</a> to not
                        to rewrite the database setup. </p>
                @endif

                <button type="submit" class="btn btn-success float-right mt-4 rounded-0">Next <i
                            class="fas fa-arrow-right ml-3"></i></button>
            </form>

            @if(session('db_error'))
                <hr>
                <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                    <strong>Error !</strong> {{ session()->get('db_error') }}

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>
<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
</body>
</html>