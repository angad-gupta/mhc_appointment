<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mail setup</title>
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">
            <p class="text-center"></p>
            <form action="{{ route('install.mail') }}" method="post" class="validate">
                @csrf
                <div class="card mt-5">
                    <h4 class="text-center pt-4">Mail setup</h4>
                    <div class="pt-2 pl-4 pr-4 pb-3">
                        <div class="form-group">
                            <label for="">Mail Host <span class="text-danger">*</span></label>
                            <input type="text" name="mail_host" value="{{ old('mail_host') }}" required
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mail Port <span class="text-danger">*</span></label>
                            <input type="text" name="mail_port" required value="{{ old('mail_port') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mail From Address <span class="text-danger">*</span></label>
                            <input type="email" name="mail_from_address" required value="{{ old('mail_from_address') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mail From Name <span class="text-danger">*</span></label>
                            <input type="text" name="mail_from_name" required value="{{ old('mail_from_name') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mail User Name <span class="text-danger">*</span></label>
                            <input type="email" name="mail_username" required value="{{ old('mail_username') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mail Password <span class="text-danger">*</span></label>
                            <input type="password" name="mail_password" required value="{{ old('mail_password') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Encryption Type</label>
                            <select name="mail_encryption" required class="form-control">
                                <option {{ setSelectOption(old('mail_encryption'), 'null') }} value="null">NULL</option>
                                <option {{ setSelectOption(old('mail_encryption'), 'ssl') }} value="ssl">SSL</option>
                                <option {{ setSelectOption(old('mail_encryption'), 'tls') }} value="tls">TLS</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix mt-4">
                    <button type="button" data-toggle="modal" data-target="#exampleModalLong"
                            class="btn btn-link float-left">Skip <i class="fas fa-forward"></i></button>
                    <button type="submit" class="btn btn-success float-right">Next <i
                                class="fas fa-arrow-right ml-3"></i></button>
                </div>

            </form>

            @if(session('mail_error'))
                <hr>
                <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                    <strong>Error !</strong> {{ session()->get('mail_error') }}

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Warning !</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>You can also configure the smtp mail later from the admin panel. </p>

                            <p>Unitll you setup the mail properly, you cannot send mail by this system. you cannot send
                                reset password link via mail unitl you setup the smtp mail.</p>

                            <p>Click "I Agree" to go forward</p>
                        </div>
                        <form action="{{ route('install.skipping-mail') }}" method="post">
                            @csrf
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">I Agree</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
</body>
</html>