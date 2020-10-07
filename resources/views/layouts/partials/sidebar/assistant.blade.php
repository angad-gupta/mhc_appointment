<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    @yield('search')

    <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ active_if_full_match('home') }}">
                <a href="{{ route('home') }}">
                    <i class="fa fa-dashboard text-fuchsia"></i> <span> {{ __('dashboard.dashboard') }}</span>
                </a>
            </li>
            <li class="header">Appointment</li>
            <li class="treeview {{ active_if_match_prefix('appointment') }}">
                <a href="#">
                    <i class="fa fa-calendar-check-o text-aqua"></i>
                    <span>{{ __('appointment.appointment') }}</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('appointment/create') }}">
                        <a href="{{ route('appointment.create') }}">
                            <i class="fa fa-plus-circle"></i> {{ __('appointment.create_appointment') }}
                        </a>
                    </li>
                    <li class="{{ active_if_full_match('appointment') }}">
                        <a href="{{ route('appointment.index')}}">
                            <i class="fa fa-bars"></i> {{ __('appointment.all_appointment') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('recent.appointment') }}">
                            <i class="fa fa-history"></i> {{ __('appointment.recent_appointment') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('on-process.appointment') }}">
                            <i class="fa fa-history"></i> {{ __('appointment.appointment_on_process') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ active_if_full_match('follow-up') }}">
                <a href="{{ route('follow-up') }}">
                    <i class="fa fa-fax text-purple"></i> {{ __('appointment.follow_up') }}
                </a>
            </li>

            <li class="header">Prescriptions</li>
            <li class="{{ active_if_full_match('prescription') }}">
                <a href="{{ route('prescription.index') }}">
                    <i class="fa fa-heartbeat"></i> <span>{{ __('prescription.prescription') }}</span>
                </a>
            </li>




            <li class="header">Accounts</li>


            <li class="{{ active_if_match_prefix('assistant') }}">
                <a href="{{ route('assistant.index') }}">
                    <i class="fa fa-user-circle-o text-info"></i>
                    <span>{{ __('assistant.assistant') }}</span>
                </a>
            </li>

            <li class="{{ active_if_match_prefix('doctor') }}">
                <a href="{{ route('doctor.index') }}">
                    <i class="fa fa-user-md text-light-blue"></i>
                    <span>{{ __('doctor.doctor') }}</span>
                </a>

            </li>
            <li class="treeview {{ active_if_match_prefix('patient') }}">
                <a href="#">
                    <i class="fa fa-wheelchair text-aqua"></i>
                    <span>{{ __('patient.patient') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('patient/create') }}"><a href="{{ route('patient.create') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('patient.create_patient') }}</a></li>
                    <li class="{{ active_if_full_match('patient') }}"><a href="{{ route('patient.index') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('patient.all_patient') }}</a></li>
                </ul>
            </li>


            <li class="header">Calender</li>
            <li>
                <a href="{{ route('calender') }}">
                    <i class="fa fa-calendar text-red"></i> <span>{{ __('calender.calender') }}</span>
                </a>
            </li>

            <li class="header">Setting</li>
            <li class="treeview {{ active_if_match_prefix('settings') }}">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>{{ __('settings.settings') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i> {{ __('settings.my_profile') }}</a></li>
                    <li class="{{ active_if_full_match('settings/change-password') }}"><a href="{{ route('change.password') }}"><i class="fa fa-key"></i>{{ __('settings.change_password') }}</a></li>
                </ul>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>