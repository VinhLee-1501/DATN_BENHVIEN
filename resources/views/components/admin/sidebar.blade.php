<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img ms-5">
                <img src="{{ asset('backend/assets/images/logos/logo.png') }}" width="120" alt=""/>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Thống kê</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span class="hide-menu">Quản lý bệnh nhân</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.medicalRecord') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.medicalRecord') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-checkup-list"></i>
                        </span>
                        <span class="hide-menu">Quản lý bệnh án</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span class="hide-menu">Quản lý bác sĩ</span>
                    </a>
                </li>
                <li class="dropdown sidebar-item">
                    <a class="sidebar-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Quản lý tài khoản</span>
                    </a>
                    <ul class="dropdown-menu ms-5" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">TK quản trị</a></li>
                        <li><a class="dropdown-item" href="#">TK bác sĩ</a></li>
                        <li><a class="dropdown-item" href="#">TK bệnh nhân</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <i class="ti ti-calendar-event"></i>
                        </span>
                        <span class="hide-menu">Quản lý lịch làm BS</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.appointmentSchedule') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.appointmentSchedule') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-calendar-event"></i>
                        </span>
                        <span class="hide-menu">Quản lý lịch khám</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
