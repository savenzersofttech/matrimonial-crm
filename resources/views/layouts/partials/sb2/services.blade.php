<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <!-- Sidenav Link (Alerts)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <!-- Sidenav Link (Messages)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>

                <!-- Services Menu Group -->
                <div class="sidenav-menu-heading">SERVICES</div>
                <a class="nav-link {{ request()->routeIs('services.dashboard') ? 'active' : '' }}" href="{{ route('services.dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="bar-chart-2"></i></div>
                    Dashboard
                </a>

                   <a class="nav-link {{ request()->routeIs('admin.profiles*') ? 'active' : '' }}" href="{{ route('admin.profiles.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Profiles
                </a>


                <a class="nav-link {{ request()->routeIs('services.welcome-calls.index') ? 'active' : '' }}" href="{{ route('services.welcome-calls.index') }}">
                    <div class="nav-link-icon"><i data-feather="phone-call"></i></div>
                    Welcome Calls
                </a>
                <a class="nav-link {{ request()->routeIs('services.services*') ? 'active' : '' }}" href="{{ route('services.services.index') }}">
                    <div class="nav-link-icon"><i data-feather="clock"></i></div>
                    Ongoing Services
                </a>
                <a class="nav-link {{ request()->routeIs('services.reports*') ? 'active' : '' }}" href="{{ route('services.reports.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Profiles Reports
                </a>
                <a class="nav-link {{ request()->routeIs('services.payments*') ? 'active' : '' }}" href="{{ route('services.payments.index') }}">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payment
                </a>
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">
                    {{ auth()->user()->name }}
                    <br>
                    <small class="text-black"><b>{{ ucfirst(auth()->user()->role) }}</b></small>
                    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="text-danger small d-block m-1">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

                   

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>

            </div>
        </div>
    </nav>
</div>
