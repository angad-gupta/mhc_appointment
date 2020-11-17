<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>M</b>A</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>MHC</b> Appointment</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
{{-- 
                @php
                    $_langs = array_map('basename', Illuminate\Support\Facades\File::directories(resource_path('lang')));
                @endphp
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @foreach($_langs as $lang)
                            @if($lang == config('app.locale'))
                                <img src="{{ getLanguageJSON($lang)['flag'] }}" alt="" height="20px;">
                            @endif
                        @endforeach
                        <span class="label label-warning">{{ config('app.locale') }}</span>
                    </a>
                    <ul class="dropdown-menu">


                        <li class="header">There is {{ count($_langs) }} different language</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    @foreach($_langs as $lang)
                                        <a href="{{ route('change-language',[$lang]) }}">
                                            <img src="{{ getLanguageJSON($lang)['flag'] }}" height="30px" alt=""> {{ getLanguageJSON($lang) != null ? getLanguageJSON($lang)['iso']. ' ('. getLanguageJSON($lang)['local'] .'- ' . getLanguageJSON($lang)['name'] .")" : '' }}
                                        </a>
                                    @endforeach
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li> --}}

                @admin
                <!-- Messages: style can be found in dropdown.less-->
                @php
                    $recent_queries = \App\Models\ContactQuery::where('checked',0)->get();
                @endphp

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-danger" style="border-radius: 10px;">{{ $recent_queries->count() }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have {{ $recent_queries->count() }} messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($recent_queries as $query)
                                    <li><!-- start message -->
                                        <a href="#">
                                            <h4>
                                                {{ $query->subject }}
                                                <small><i class="fa fa-clock-o"></i> {{ $query->created_at->format('d-M-Y') }}</small>
                                            </h4>
                                            <p>{{ str_limit($query->message,200,'...') }}</p>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </li>
                        <li class="footer"><a href="{{ route('contact-query.index') }}">See All Messages</a></li>
                    </ul>
                </li>
                @endadmin
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(auth()->user()->photo ? auth()->user()->photo : 'dash/img/boxed-bg.jpg') }}" class="user-image"
                             alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->full_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset(auth()->user()->photo ? auth()->user()->photo : 'dash/img/boxed-bg.jpg') }}"
                                 class="img-circle" alt="User Image">

                            <p>
                                {{ auth()->user()->full_name }}
                                <small> {{ authUserRoleName() }} since {{ auth()->user()->created_at->format('M , Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="{{ route('change.password') }}">Change Password</a>
                                </div>

                                {{-- <div class="col-xs-6 text-center">
                                    <a href="{{ route('change.password') }}">Change Email</a>
                                </div> --}}
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign
                                    out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>