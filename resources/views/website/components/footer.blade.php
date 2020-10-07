<footer>
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-4">
                <h4>{{ __('website.footer.get_in_touch') }}</h4>
                <ul class="list-inline pt-4 social">
                    <li class="list-inline-item">
                        <a href="{{ $contact ? $contact->fb_link : '#' }}"><i class="fab fa-facebook-square"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ $contact ? $contact->twitter_link : '#' }}"><i
                                    class="fab fa-twitter-square"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ $contact ? $contact->linked_in_link : '#' }}"><i class="fab fa-linkedin"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ $contact ? $contact->instragram_link : '#' }}"><i class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 text-justify">
                <h4>{{ __('website.footer.hours') }}</h4>

                <p>
                    {!! nl2br(e($about ? $about->opening_hours : '')) !!}
                </p>
            </div>

            <div class="col-md-2 ">
                <h4>{{ __('website.footer.quick_links') }}</h4>
                <ul class="list-unstyled pt-4">
                    <li><a href="{{ url('/') }}">{{ __('website.nav.home') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('website.nav.contact') }}</a></li>
                    <li><a href="{{ route('w.doctors') }}">{{ __('website.nav.meet_doctor') }}</a></li>
                    <li><a href="{{ route('w.appointment') }}">{{ __('website.nav.get_appointment') }}</a></li>
                    <li><a href="{{ route('login') }}">{{ __('website.nav.login') }}</a></li>
                </ul>
            </div>

            <div class="col-md-3 text-right">
                <h4>{{ __('website.footer.contact_us') }}</h4>

                <p class="pt-4">
                    <i class="fas fa-map-signs"></i> {{ $contact ? $contact->address  : '' }} <br/>
                    <i class="fas fa-mobile-alt"></i> {{ $contact ? $contact->phone : '' }} <br/>
                    <i class="far fa-envelope"></i> {{ $contact ? $contact->mail : '' }}
                </p>
            </div>
        </div>
    </div>
</footer>
