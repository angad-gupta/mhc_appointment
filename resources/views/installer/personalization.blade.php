<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personalization</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('web/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 offset-md-4">

            <form action="{{ route('install.personalization') }}" method="post" class="validate">
                @csrf
                <div class="card mt-5 p-4 rounded-0">
                    <h4 class="text-center pt-4">Personalization</h4>
                    <div class="form-group">
                        <label for="">App Host</label>
                        <input type="text" value="{{ Request::root() }}" name="app_url" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">App Name</label>
                        <input type="text" name="app_name" required value="{{ config('app.name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">App Logo</label>
                        <input type="file" name="logo" accept="image/png" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">App Banner Image</label>
                        <input type="file" name="banner" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">App Debug</label>
                        <select name="app_debug" required class="form-control">
                            <option value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">App Local</label>
                        <select name="app_local" required class="form-control">
                            @foreach($langs as $lang)
                                <option {{ setSelectOption( config('app.locale'), $lang ) }} value="{{ $lang }}"> {{ getLanguageJSON($lang) != null ? getLanguageJSON($lang)['iso']. ' ('. getLanguageJSON($lang)['local'] .'- ' . getLanguageJSON($lang)['name'] .")" : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">App Timezone</label>
                        <select name="timezone" required class="form-control">
                            @foreach(phpTimeZones() as $key=>$timezone)
                                <option {{ setSelectOption(config('app.timezone'), $key) }} value="{{ $key }}">{{ $timezone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right mt-4 rounded-0">Next <i class="fas fa-arrow-right ml-3"></i>
                </button>


            </form>


        </div>
    </div>
</div>
<script src="{{ asset('web/app.bundle.js') }}"></script>
<script src="{{ asset('web/form.bundle.js') }}"></script>
</body>
</html>