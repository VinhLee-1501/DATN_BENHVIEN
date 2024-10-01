@if (auth()->check())
    @if (auth()->user()->role == 1)
        <aside class="left-sidebar">
            <!-- Cuộn thanh bên -->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#" class="text-nowrap logo-img ms-5">
                        <img src="{{ asset('backend/assets/images/logos/logo.png') }}" width="120" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Điều hướng thanh bên -->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="sidebar-item {{ request()->routeIs('system.dashboard') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('system.dashboard') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Thống kê (System)</span>
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
                        <li class="sidebar-item {{ request()->routeIs('system.medicalRecord') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('system.medicalRecord') }}" aria-expanded="false">
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
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('system.medicine') }}" aria-expanded="false">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-vaccine-bottle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path
                                            d="M10 6v.98c0 .877 -.634 1.626 -1.5 1.77c-.866 .144 -1.5 .893 -1.5 1.77v8.48a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-8.48c0 -.877 -.634 -1.626 -1.5 -1.77a1.795 1.795 0 0 1 -1.5 -1.77v-.98" />
                                        <path d="M7 12h10" />
                                        <path d="M7 18h10" />
                                        <path d="M11 15h2" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Quản lý thuốc</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('system.medicineType') }}" aria-expanded="false">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-heart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path
                                            d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path
                                            d="M11.993 16.75l2.747 -2.815a1.9 1.9 0 0 0 0 -2.632a1.775 1.775 0 0 0 -2.56 0l-.183 .188l-.183 -.189a1.775 1.775 0 0 0 -2.56 0a1.899 1.899 0 0 0 0 2.632l2.738 2.825z" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Quản lý danh mục thuốc</span>
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
                            <a class="sidebar-link" href="{{route('system.schedule')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-calendar-event"></i>
                                </span>
                                <span class="hide-menu">Quản lý lịch làm BS</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('system.appointmentSchedule') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('system.appointmentSchedule') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-calendar-event"></i>
                                </span>
                                <span class="hide-menu">Quản lý lịch khám</span>
                            </a>
                        </li>
                    </ul>
                    </li>
            </div>
            <!-- Điều hướng thanh bên -->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="sidebar-item {{ request()->routeIs('system.dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('system.dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Thống kê (Bác sĩ)</span>
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
                    <li class="sidebar-item {{ request()->routeIs('system.medicalRecord') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('system.medicalRecord') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-checkup-list"></i>
                            </span>
                            <span class="hide-menu">Quản lý bệnh án</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('system.appointmentSchedule') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('system.appointmentSchedule') }}"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar-event"></i>
                            </span>
                            <span class="hide-menu">Quản lý lịch khám</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Kết thúc Điều hướng thanh bên -->

            <!-- Kết thúc Cuộn thanh bên -->
        </aside>
    @endif
@endif
