@extends('website.components.app')

@section('title') {{ __('website.footer.contact_us') }} @endsection

@section('content')

    <div class="page-banner" style="background-image: url('{{ asset('web/images/b8cb9975d682ff9c6c1aa57192db086e.jpg') }}')">
        <h4 class="title text-center pt-4">
            {{ __('website.footer.contact_us') }}
            <span></span>
        </h4>
    </div>

    <div class="contact">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('contact-query.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('website.form.full_name') }}</label>
                            <input type="text" name="full_name" class="form-control" placeholder="{{ __('website.form.full_name') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('website.form.email_address') }}</label>
                            <input type="email" name="email_address" class="form-control"
                                   placeholder="{{ __('website.form.email_address') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('website.form.subject') }}</label>
                            <input type="text" name="subject" class="form-control" placeholder="{{ __('website.form.subject') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('website.form.message') }}</label>
                            <textarea name="message" rows="5" class="form-control"
                                      placeholder="{{ __('website.form.message') }}"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-0">{{ __('actions.submit') }}</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <iframe src="{{ $contact ? $contact->google_map : '' }}" width="100%" height="500PX" frameborder="0" style="border:0;"
                            allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection