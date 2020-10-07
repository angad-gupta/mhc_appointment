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

            <li class="{{ active_if_full_match('patient-payment') }}">
                <a href="{{ route('patient-payment.index') }}" class="text-black-50">
                    <i class="fa fa-money"></i> <span> {{ __('payment.title') }}</span>
                </a>
            </li>


            <li class="header">Accounts</li>
            <li class="treeview {{ active_if_match_prefix('admin') }}">
                <a href="#">
                    <i class="fa fa-users text-maroon"></i>
                    <span>{{ __('admin.admin_users') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('admin/create') }}"><a href="{{ route('admin.create') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('admin.create_admin') }}</a></li>
                    <li class="{{ active_if_full_match('admin') }}"><a href="{{ route('admin.index') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('admin.all_admin') }}</a></li>
                </ul>
            </li>



            <li class="treeview {{ active_if_match_prefix('doctor') }}">
                <a href="#">
                    <i class="fa fa-user-md text-light-blue"></i>
                    <span>{{ __('doctor.doctor') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('doctor/create') }}">
                        <a href="{{ route('doctor.create') }}">
                            <i class="fa fa-circle-o"></i> {{ __('doctor.create_doctor') }}
                        </a>
                    </li>
                    <li class="{{ active_if_full_match('doctor') }}">
                        <a href="{{ route('doctor.index') }}">
                            <i class="fa fa-circle-o"></i> {{ __('doctor.all_doctor') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ active_if_match_prefix('patient') }}">
                <a href="#">
                    <i class="fa fa-wheelchair text-aqua"></i>
                    <span> {{ __('patient.patient') }} </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('patient/create') }}">
                        <a href="{{ route('patient.create') }}">
                            <i class="fa fa-circle-o"></i> {{ __('patient.create_patient') }} </a>
                    </li>
                    <li class="{{ active_if_full_match('patient') }}">
                        <a href="{{ route('patient.index') }}">
                            <i class="fa fa-circle-o"></i> {{ __('patient.all_patient') }}</a>
                    </li>
                </ul>
            </li>
            <li class="header">Department</li>
            <li class="treeview {{ active_if_match_prefix('drug') }}">
                <a href="#">
                    <i class="fa fa-eyedropper text-blue"></i>
                    <span>{{ __('drug.drug') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('drug/create') }}"><a href="{{ route('drug.create') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('drug.create_drug') }}</a></li>
                    <li class="{{ active_if_full_match('drug') }}"><a href="{{ route('drug.index') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('drug.all_drug') }} </a></li>
                    <li class="{{ active_if_full_match('report/drug') }}">
                        <a href="{{ route('report.drug') }}">
                            <i class="fa fa-circle-o"></i> {{ __('drug.report') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ active_if_match_prefix('department') }}">
                <a href="#">
                    <i class="fa fa-sitemap text-orange"></i>
                    <span>{{ __('department.department') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active_if_full_match('department/create') }}"><a
                                href="{{ route('department.create') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('department.create_department') }}</a></li>
                    <li class="{{ active_if_full_match('department') }}"><a href="{{ route('department.index') }}"><i
                                    class="fa fa-circle-o"></i> {{ __('department.all_department') }} </a></li>
                </ul>
            </li>
            <li class="header">Calender & Others</li>
            <li>
                <a href="{{ route('calender') }}">
                    <i class="fa fa-calendar text-red"></i> <span>{{ __('calender.calender') }}</span>
                </a>
            </li>


            <li>
                <a href="{{ route('contact-query.index') }}">
                    <i class="fa fa-envelope text-green"></i> <span>{{ __('mailbox.mailbox') }}</span>
                </a>
            </li>

            {{-- <li class="header">Setting</li>
            <li class="treeview {{ active_if_match_prefix('settings') }}">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>{{ __('settings.settings') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('profile') }}"><i class="fa fa-user"></i> {{ __('settings.my_profile') }}</a>
                    </li>
                    <li class="{{ active_if_full_match('settings/change-password') }}">
                        <a href="{{ route('change.password') }}"><i class="fa fa-key"></i>{{ __('settings.change_password') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('app.setup') }}"><i class="fa fa-cog"></i>{{ __('settings.app_setup') }}</a>
                    </li>
                    <li class="{{ active_if_full_match('settings/invoice-setting') }}">
                        <a href="{{ route('invoice-setting.index') }}"><i class="fa fa-cog"></i>{{ __('settings.invoice_setup.title') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('website.setup') }}"><i class="fa fa-globe"></i> {{ __('settings.web_setup.title') }}</a>
                    </li>
                </ul>
            </li> --}}


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
