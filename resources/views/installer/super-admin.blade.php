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
        <div class="col-md-4 offset-md-4">
            <p class="text-center"></p>
            <form action="{{ route('install.admin') }}" method="post" class="validate">
                @csrf
                <div class="card mt-5">
                    <h4 class="text-center pt-4">Super Admin Setup</h4>
                    <div class="pt-2 pl-4 pr-4 pb-3">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Title <span class="text-danger">*</span> </label>
                                    <input type="text" required class="form-control" name="title"
                                           value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" required class="form-control" name="full_name"
                                           value="{{ old('full_name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input type="email" required class="form-control" name="email" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="">User Name</label>
                            <input type="text" required data-parsley-alphadash="" class="form-control" name="user_name"
                                   value="{{ old('user_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" required class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="">Re-Type Password <span class="text-danger">*</span></label>
                            <input type="password" data-parsley-equalto="#password" name="password_confirmation"
                                   required class="form-control">
                        </div>


                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right mt-4 mb-5 rounded-0">Next <i
                            class="fas fa-arrow-right ml-3"></i></button>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


        </div>
    </div>
</div>
<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
<script>
    window.Parsley.addValidator('alphadash', {
        validateString: function (value) {
            return true == (/^[a-z-_]+$/.test(value));
        },
        messages: {
            en: 'Only alphabetic letters, dashes and underscores allowed.'
        }
    });
</script>
</body>
</html>