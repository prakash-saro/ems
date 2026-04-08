<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="20">
            </span>
        </a>

        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('viewAny', \App\Models\Employee::class)
                    <li class="{{ request()->routeIs('employee.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('employee.index') }}"
                            class="{{ request()->routeIs('employee.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                @endcan

                <li class="{{ request()->routeIs('attendance.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('attendance.index') }}"
                        class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i>
                        <span>Attendance</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('leave.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('leave.index') }}" class="{{ request()->routeIs('leave.*') ? 'active' : '' }}">
                        <i class="far fa-calendar-check"></i>
                        <span>Leave</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('timesheet.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('timesheet.index') }}"
                        class="{{ request()->routeIs('timesheet.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Timesheet</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
