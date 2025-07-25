<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">
                <span class="logo-name">{{ env('APP_NAME') }}</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <!-- Admin Menu Group -->
            <li class="menu-header">Admin</li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Dashboard</span>
                </a>
            </li>
           
            <li class="dropdown {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="briefcase"></i><span>Employee</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.employees.index') }}">All Employee</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.employees.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.employees.create') }}">Add Employee</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('admin.profiles.index') ? 'active' : '' }}">
                <a href="{{ route('admin.profiles.index') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Profiles</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">
                <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                    <i data-feather="shield"></i><span>Roles</span>
                </a>
            </li>

            

            <li class="dropdown {{ request()->routeIs('admin.assigns.*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="briefcase"></i><span>Assign Profiles</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.assigns.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.assigns.index') }}">All Assigns</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.assigns.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.assigns.create') }}">Assign New</a>
                    </li>
                </ul>
            </li>


            <!-- Sales Menu Group -->
            <li class="menu-header">Sales</li>
            <li class="{{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
                <a href="{{ route('sales.dashboard') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Dashboard</span>
                </a>
            </li>
            

           

            <!-- Services Menu Group -->
            <li class="menu-header">Services</li>
            <li class="{{ request()->routeIs('services.dashboard') ? 'active' : '' }}">
                <a href="{{ route('services.dashboard') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Dashboard</span>
                </a>
            </li>


            <li class="{{ request()->routeIs('services.welcome-calls.index') ? 'active' : '' }}">
                <a href="{{ route('services.welcome-calls.index') }}" class="nav-link">
                    <i class="fa-solid fa-phone"></i><span>Welcome  Calls</span>
                </a>
            </li>

          

           <li class="dropdown {{ request()->routeIs('services.profile-reports.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link"><i data-feather="file-text"></i><span>Profiles Reports</span></a>
           </li>
        </ul>
    </aside>
</div>
