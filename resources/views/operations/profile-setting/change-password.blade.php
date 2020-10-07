@extends('layouts.app')

@section('title')
    {{ __('settings.account_setup.title') }}
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('settings.account_setup.title') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('update.password') }}" method="post" id="form">
                        @csrf
                        <h3>{{ __('settings.change_password') }}</h3>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.current_password') }} <span class="text-danger">*</span></label>
                            <input required type="password" name="current_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.new_password') }} <span class="text-danger">*</span></label>
                            <input required type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.re_type_new_password') }} <span class="text-danger">*</span></label>
                            <input required type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-primary btn-flat" type="submit">{{ __('actions.submit') }}</button>
                    </form>
                </div>

                {{-- <div class="col-md-6">
                    <form action="{{ route('update.email') }}" method="post" id="update_form">
                        @csrf
                        <h3>{{ __('settings.account_setup.change_email') }}</h3>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.current_password') }} <span class="text-danger">*</span></label>
                            <input required type="password" name="current_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('passwords.password') }} <span class="text-danger">*</span></label>
                            <input required type="email" name="email" class="form-control">
                        </div>
                        <button class="btn btn-primary btn-flat" type="submit">{{ __('actions.submit') }}</button>
                    </form>
                </div> --}}
            </div>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('update.username') }}" method="post" id="updateUserName">
                        @csrf
                        <h3>{{ __('settings.change_user_name') }}</h3>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.current_password') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="current_password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('settings.account_setup.user_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="user_name" required class="form-control">
                        </div>
                        <button class="btn btn-primary btn-flat" type="submit">{{ __('actions.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-footer">

        </div>
    </div>
@endsection

@section('js')

    <script>
        $(function () {
            $("#updateUserName").on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('update.username') }}',
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $(this).showLoader(false);
                        toastr.success(data[0], data[1]);

                    }, error: function (data) {
                        $(this).showLoader(false);
                        if (data.status === 422) {
                            $(this).showValidationError(data);
                        } else if (data.status === 421) {
                            toastr.error(data.responseJSON[0], data.responseJSON[1]);
                        } else {
                            toastr.error(data.responseJSON.message);
                        }
                    }
                })
            })
        })
    </script>

@endsection