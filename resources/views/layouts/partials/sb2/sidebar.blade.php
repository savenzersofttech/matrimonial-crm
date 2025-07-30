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
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->

                <a class="nav-link" href="/admin/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboards
                </a>


                 <a class="nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Employees
                </a>

                  <a class="nav-link {{ request()->routeIs('admin.profiles*') ? 'active' : '' }}" href="{{ route('admin.profiles.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Profiles
                </a>

                <a class="nav-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                    <div class="nav-link-icon"><i data-feather="shield"></i></div>
                    Roles
                </a>
                
                 <a class="nav-link {{ request()->routeIs('admin.assigns*') ? 'active' : '' }}" href="{{ route('admin.assigns.index') }}">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Assign
                </a>

                <a class="nav-link {{ request()->routeIs('admin.sales-targets*') ? 'active' : '' }}" href="{{ route('admin.sales-targets.index') }}">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Sales Targets
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
