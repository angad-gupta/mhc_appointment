<header id="js-header" class="u-header u-header--static">
  <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3">
    <nav class="js-mega-menu navbar navbar-expand-lg hs-menu-initialized hs-menu-horizontal">
      <div class="container">
        <!-- Responsive Toggle Button -->
        <button
          class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-3 g-right-0"
          type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar"
          data-toggle="collapse" data-target="#navBar">
          <span class="hamburger hamburger--slider">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </span>
        </button>
        <!-- End Responsive Toggle Button -->
        <!-- Logo -->
        <a href="{{URL::to('/')}}" class="navbar-brand">
          <img src="https://www.merohealthcare.com/assets/images/1592375295logo.jpg" height="60" width="100"
            alt="Unify Logo">
        </a>
        <!-- End Logo -->
        <!-- Navigation -->
        <div class="collapse navbar-collapse align-items-center flex-sm-row g-mr-40--lg" id="navBar">
          <ul class="navbar-nav g-pos-rel g-font-weight-600 mr-auto">
            <li class="nav-item nav-item-hover g-mx-5--lg g-mx-5--xl {{Request::routeIs('/') ? 'active' : ''}}">
              <a href="{{route('/')}}" class="nav-link">
                <div class="g-py-2 g-px-0 nav-item-child">Home</div>
                <div class="header-menu-summary">Check whats new</div>
              </a>
            </li>
            <li class="nav-item nav-item-hover g-mx-5--lg g-mx-5--xl {{Request::routeIs('w.appointment') ? 'active' : ''}}">
              <a href="{{route('w.appointment')}}" class="nav-link">
                <div class="g-py-2 g-px-0 nav-item-child">Doctors</div>
                <div class="header-menu-summary">Book appointment</div>
              </a>
            </li>
            {{-- @guest --}}
            @if (!Auth::guard('web')->check() && !Auth::guard('extra_user')->check())
            <li class="nav-item nav-item-hover g-mx-5--lg g-mx-5--xl {{Request::routeIs('register') ? 'active' : ''}}">
              <a href="{{route('register')}}" class="nav-link">
                <div class="g-py-2 g-px-0 nav-item-child">Get Listed</div>
                <div class="header-menu-summary">List your practice</div>
              </a>
            </li>
            {{-- @endguest --}}
            @endif
          </ul>
        </div>
        <!-- End Navigation -->

        <div class="d-inline-block justify-content-between g-pos-rel g-valign-middle g-pt-10 g-pl-0--lg">
          <div
            class="row flex-row align-items-start align-items-lg-center text-uppercase g-font-weight-600 u-header--hidden-element g-color-gray-dark-v2 g-font-size-12 text-lg-right g-mt-minus-10 g-mb-20">
            @php
             if (!Auth::guard('web')->guest()) {
                $status = Auth::user()->status;
                if($status == 0){
                  Auth::logout();
                }
             }
            @endphp
            @if (!Auth::guard('web')->check() && !Auth::guard('extra_user')->check())

              <div class="col-auto g-px-5 g-pt-5 g-mt-10">

                  <a href="{{ route('login') }}"class="btn btn-sm u-btn-outline-primary"> Doctor Login</a>&nbsp;&nbsp;

                  <a href="{{ route('patient.login') }}"class="btn btn-sm u-btn-outline-primary"> Patient Login</a>
              </div>
            @else
            <div class="dropdown g-mb-10 g-mb-0--md">
              <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5 g-pt-12"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="font-size: 15px;margin-top: 6px;">
                <i class="fa fa-user-circle g-pos-rel g-top-1"></i> My account <i class="fa fa-chevron-down" aria-hidden="true"></i>
              </span>
              <div class="dropdown-menu rounded-0 g-mt-10">
                <a href="{{ route('home') }}" class="dropdown-item {{ active_if_full_match('home') }}">
                  <i class="fa fa-superpowers"></i>
                  {{ __('website.nav.account.dashboard') }}
                </a>
                @if(Auth::guard('extra_user')->check())
                <a class="dropdown-item" href="{{ route('web.patient.appointments') }}">
                  <i class="fa fa-calendar"></i> {{ __('appointment.appointment') }}</a>

                <a href="{{ route('web.patient.prescriptions') }}"
                  class="dropdown-item {{ active_if_full_match('w/patient/prescriptions') }}">
                  <i class="fa fa-file"></i> {{ __('prescription.prescription') }}
                </a>
                <a href="{{ route('web.patient.payments') }}"
                  class="dropdown-item {{ active_if_full_match('w/patient/payments') }}">
                  <i class="fa fa-credit-card"></i> {{ __('payment.title') }}
                </a>
                <a href="{{ route('web.patient.notes') }}"
                  class="dropdown-item {{ active_if_full_match('w/patient/notes') }}">
                  <i class="fa fa-clipboard"></i> {{ __('note.note') }}
                </a>
                <a href="{{ route('web.patient.documents') }}"
                  class="dropdown-item {{ active_if_full_match('w/patient/documents') }}">
                  <i class="fa fa-medkit"></i> {{ __('document.document') }}
                </a>
                <a href="{{ route('web.patient.setting') }}"
                  class="dropdown-item {{ active_if_full_match('w/patient/setting') }}">
                  <i class="fa fa-cogs"></i> {{ __('settings.settings') }}
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0)"
                  onclick="document.getElementById('logOutForm').submit()"><i class="fa fa-sign-out"></i>
                  {{ __('website.nav.account.logout') }}</a>
              </div>
            </div>
            <form action="{{ Auth::guard('extra_user')->check() ? route('patient.logout') : route('logout') }}" id="logOutForm" method="post">
              @csrf
            </form>
            @endif
          </div>
        </div>
    </nav>
  </div>
</header>