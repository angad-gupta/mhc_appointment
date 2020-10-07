@extends('layouts.app')

@section('title') {{ config('app.name') }} Setup @endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">App Setup</h4>

        </div>
        <div class="box-body">
            <p>After modification you need to clear the server cache to apply the changes. to clear the server cache <a
                        href="javascript:void(0)"
                        onclick="$('#configCache').submit()">click
                    here</a></p>
            <form action="{{ route('config.cache') }}" id="configCache" method="post">
                @csrf
            </form>

            <div class="row">

                <div class="col-md-6">
                    <h4>Application Setup</h4>
                    <form action="{{ route('store.app.setup') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="">APP_LOGO</label>
                            <input type="file" name="logo" accept="image/jpeg,image/png" id="" class="form-control">
                            @if($errors->has('logo'))
                                <small class="text-danger">{{ $errors->first('logo') }}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">APP_BANNER</label>
                            <input type="file" name="banner" class="form-control" accept="image/jpeg, image/png">
                            @if($errors->has('banner'))
                                <small class="text-danger">{{ $errors->first('banner') }}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">APP_NAME</label>
                            <input type="text" required name="app_name"
                                   value="{{ old('app_name') == null ? config('app.name') : old('app_name') }}"
                                   class="form-control">
                            @if ($errors->has('app_name'))
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('app_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">APP_DEBUG</label>
                            <select name="app_debug" required class="form-control">
                                <option {{ setSelectOption(config('app.debug'), 1) }} value="true">True</option>
                                <option {{ setSelectOption(config('app.debug'), 0) }} value="false">False</option>
                            </select>
                            @if ($errors->has('app_debug'))
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('app_debug') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">APP_URL</label>
                            <input type="text" readonly id="app_url" class="form-control" name="app_url"
                                   value="{{ config('app.url') }}">
                        </div>
                        <div class="form-group">
                            <label for="">APP_LOCAL</label>
                            <select name="app_local" class="form-control">
                                @foreach($langs as $lang)
                                    <option {{ setSelectOption( config('app.locale'), $lang ) }} value="{{ $lang }}">{{ getLanguageJSON($lang) != null ? getLanguageJSON($lang)['iso']. ' ('. getLanguageJSON($lang)['local'] .'- ' . getLanguageJSON($lang)['name'] .")" : '' }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('app_local'))
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('app_local') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">APP_TIMEZONE {{ config('app.timezone') }}</label>
                            <select name="timezone" class="form-control">
                                @foreach(phpTimeZones() as $key=>$timezone)
                                    <option {{ config('app.timezone') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $timezone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat">{{ __('actions.submit') }}</button>
                    </form>
                </div>


                <div class="col-md-6">
                    <h4>Database Setup</h4>
                    <form action="javascript:void(0)">
                        <div class="form-group">
                            <label for="">DB_CONNECTION</label>
                            <input type="text" class="form-control" readonly value="{{ config('database.default') }}">
                        </div>
                        <div class="form-group">
                            <label for="">DB_HOST</label>
                            <input type="text" class="form-control" name="db_host"
                                   value="{{ config('database.connections.mysql.host') }}">
                        </div>
                        <div class="form-group">
                            <label for="">DB_PORT</label>
                            <input type="text" class="form-control" name="db_port"
                                   value="{{ config('database.connections.mysql.port') }}">
                        </div>
                        <div class="form-group">
                            <label for="">DB_DATABASE</label>
                            <input type="text" class="form-control" name="db_database"
                                   value="{{ config('database.connections.mysql.database') }}">
                        </div>
                        <div class="form-group">
                            <label for="">DB_USERNAME</label>
                            <input type="text" class="form-control" name="db_username"
                                   value="{{ config('database.connections.mysql.username') }}">
                        </div>
                        <div class="form-group">
                            <label for="">DB_PASSWORD</label>
                            <input type="text" class="form-control" name="db_password" value="********">
                        </div>
                        <button type="button" disabled="" class="btn btn-primary btn-flat">{{ __('actions.submit') }}</button>
                    </form>
                </div>


            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Mail Setup</h4>
                    <form action="{{ route('mail.setup') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">MAIL_DRIVER</label>
                            <input type="text" class="form-control" value="{{ config('mail.driver') }}">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_HOST</label>
                            <input type="text" class="form-control" name="mail_host" value="{{ config('mail.host') }}">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_PORT</label>
                            <input type="text" class="form-control" name="mail_port" value="{{ config('mail.port') }}">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_USERNAME</label>
                            <input type="text" class="form-control" name="mail_username"
                                   value="{{ config('mail.username') }}">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_PASSWORD</label>
                            <input type="text" class="form-control" name="mail_password" value="******">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_ENCRYPTION</label>
                            <select name="mail_encryption" id="" class="form-control">
                                <option {{ setSelectOption(config('mail.encryption'), null) }} value=null>No
                                    Encryption (Non-SSL Recommended)
                                </option>
                                <option {{ setSelectOption(config('mail.encryption'), 'ssl') }} value="ssl">SSL (Secure
                                    SSL Recommended)
                                </option>
                                <option {{ setSelectOption(config('mail.encryption'),'tls') }} value="tls">TLS (Secure
                                    SSL Recommended)
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_FROM_ADDRESS</label>
                            <input type="text" name="mail_from_address" class="form-control"
                                   value="{{ config('mail.from.address') }}">
                        </div>
                        <div class="form-group">
                            <label for="">MAIL_FROM_NAME</label>
                            <input type="text" name="mail_from_name" class="form-control"
                                   value="{{ config('mail.from.name') }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat">{{ __('actions.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        ;(function ($) {
            // Default options
            var defaults = {
                threshold: 1000, // ms
            }

            function tripleHandler(event) {
                var $elem = jQuery(this);

                // Merge the defaults and any user defined settings.
                settings = jQuery.extend({}, defaults, event.data);

                // Get current values, or 0 if they don't yet exist.
                var clicks = $elem.data("triclick_clicks") || 0;
                var start = $elem.data("triclick_start") || 0;

                // If first click, register start time.
                if (clicks === 0) {
                    start = event.timeStamp;
                }

                // If we have a start time, check it's within limit
                if (start != 0
                    && event.timeStamp > start + settings.threshold) {
                    // Tri-click failed, took too long.
                    clicks = 0;
                    start = event.timeStamp;
                }

                // Increment counter, and do finish action.
                clicks += 1;
                if (clicks === 3) {
                    clicks = 0;
                    start = 0;
                    event.type = "tripleclick";

                    // Let jQuery handle the triggering of "tripleclick" event handlers
                    if (jQuery.event.handle === undefined) {
                        jQuery.event.dispatch.apply(this, arguments);
                    } else {
                        // for jQuery before 1.9
                        jQuery.event.handle.apply(this, arguments);
                    }
                }

                // Update object data
                $elem.data("triclick_clicks", clicks);
                $elem.data("triclick_start", start);
            }

            var tripleclick = $.event.special.tripleclick =
                {
                    setup: function (data, namespaces) {
                        $(this).bind("touchstart click.triple", data, tripleHandler);
                    },
                    teardown: function (namespaces) {
                        $(this).unbind("touchstart click.triple", data, tripleHandler);
                    }
                };
        })(jQuery);

        $(function () {


            $('#app_url').bind('tripleclick', function (e) {
                e.preventDefault();
                $(this).removeAttr('readonly');
            })
        })
    </script>
@endsection