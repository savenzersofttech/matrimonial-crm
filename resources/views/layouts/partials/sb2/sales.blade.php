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
              
               
            
                <!-- SALE Menu Group -->
                <div class="sidenav-menu-heading">SALES</div>
                <a class="nav-link {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}" href="{{ route('sales.dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="bar-chart-2"></i></div>
                    Dashboard
                </a>
                   <a class="nav-link {{ request()->routeIs($role . '.profiles*') ? 'active' : '' }}" href="{{ route($role . '.profiles.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Profiles
                </a>

                 <a class="nav-link {{ request()->routeIs('sales.leads*') ? 'active' : '' }}" href="{{ route('sales.leads.index') }}">
                    <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
                    Leads
                </a>

                <a class="nav-link {{ request()->routeIs('sales.sales*') ? 'active' : '' }}" href="{{ route('sales.sales.index') }}">
                    <div class="nav-link-icon"><i data-feather="trending-up"></i></div>
                    Sales
                </a>

                 <a class="nav-link {{ request()->routeIs('sales.target.index') ? 'active' : '' }}" href="{{ route('sales.target.index') }}">
                    <div class="nav-link-icon"><i data-feather="target"></i></div>
                    Target
                </a>


                <a class="nav-link {{ request()->routeIs('sales.tasks.index') ? 'active' : '' }}" href="{{ route('sales.tasks.index') }}">
                    <div class="nav-link-icon"><i data-feather="check-square"></i></div>
                    Tasks
                </a>

                <a class="nav-link {{ request()->routeIs('sales.follow-up.index') ? 'active' : '' }}" href="{{ route('sales.follow-up.index') }}">
                    <div class="nav-link-icon"><i data-feather="repeat"></i></div>
                    Follow up
                </a>

                <a class="nav-link {{ request()->routeIs('sales.follow-up.index') ? 'active' : '' }}" href="{{ route('sales.follow-up.index') }}">
                    <div class="nav-link-icon"><i data-feather="bar-chart-2"></i></div>
                   Reports
                </a>
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </nav>
</div>
