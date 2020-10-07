<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-6">
                <a href="{{ url('/') }}" class="icon">
                    <img src="https://merohealthcare.com/assets/images/1589282735DP-FB.jpg" style="height:4.5rem;"ass="img-fluid" alt=""/>
                </a>
            </div>

            <div class="col-md-8 text-right col-6">
                <p class="mb-0 pt-4">{{ __('website.nav.get_appointment') }}</p>
                <a href="" class="btn btn-primary">{{ $contact ? $contact->phone : '' }}</a>
            </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand d-md-none" href="#">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ active_if_full_match('/') }}">
                    <a class="nav-link" href="{{ url('/') }}">{{ __('website.nav.home') }} <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ active_if_full_match('w/doctors') }}">
                    <a class="nav-link" href="{{ route('w.doctors') }}">{{ __('website.nav.meet_doctor') }}</a>
                </li>

                <li class="nav-item {{ active_if_full_match('w/appointment') }}">
                    <a class="nav-link" href="{{ route('w.appointment') }}">{{ __('website.nav.get_appointment') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item {{ active_if_full_match('contact') }}">
                    <a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-headset"></i> {{ __('website.nav.contact') }}</a>
                </li>
                @guest
                    <li class="nav-item {{ active_if_full_match('login') }}">
                        <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> {{ __('website.nav.login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ __('website.nav.account.my_account') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route('home') }}" class="dropdown-item {{ active_if_full_match('home') }}">
                                <i class="fab fa-superpowers"></i> {{ __('website.nav.account.dashboard') }}</a>
                            @patient
                            <a class="dropdown-item" href="{{ route('web.patient.appointments') }}">
                                <i class="far fa-calendar-check"></i> {{ __('appointment.appointment') }}</a>

                            <a href="{{ route('web.patient.prescriptions') }}" class="dropdown-item {{ active_if_full_match('w/patient/prescriptions') }}">
                                <i class="fas fa-file-prescription"></i> {{ __('prescription.prescription') }}
                            </a>
                            <a href="{{ route('web.patient.payments') }}" class="dropdown-item {{ active_if_full_match('w/patient/payments') }}">
                                <i class="fas fa-credit-card"></i> {{ __('payment.title') }}
                            </a>
                            <a href="{{ route('web.patient.notes') }}" class="dropdown-item {{ active_if_full_match('w/patient/notes') }}">
                                <i class="far fa-clipboard"></i> {{ __('note.note') }}
                            </a>
                            <a href="{{ route('web.patient.documents') }}" class="dropdown-item {{ active_if_full_match('w/patient/documents') }}">
                                <i class="fas fa-file-medical-alt"></i> {{ __('document.document') }}
                            </a>
                            <a href="{{ route('web.patient.setting') }}" class="dropdown-item {{ active_if_full_match('w/patient/setting') }}">
                                <i class="fas fa-cogs"></i> {{ __('settings.settings') }}
                            </a>
                            @endpatient
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)"
                               onclick="document.getElementById('logOutForm').submit()"><i
                                        class="fas fa-sign-out-alt"></i> {{ __('website.nav.account.logout') }}</a>
                        </div>
                        <form action="{{ route('logout') }}" id="logOutForm" method="post">
                            @csrf
                        </form>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
