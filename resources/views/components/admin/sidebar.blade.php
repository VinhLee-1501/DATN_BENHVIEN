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
        <nav class="sidebar-nav scroll-sidebar " data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ request()->is('system/dashboard*') || request()->is('system/dashboard?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.dashboard') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                                <path
                                    d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                            </svg>
                        </span>
                        <span class="hide-menu">Thống kê (System)</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/patient*') || request()->is('system/patient?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.patient') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bệnh nhân</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/medicalRecord*') || request()->is('system/medicalRecord?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.medicalRecord') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path
                                    d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M9 12h6" />
                                <path d="M9 16h6" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bệnh án</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/doctor*') || request()->is('system/doctor?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.doctor') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bác sĩ</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/specialties*') || request()->is('system/specialties?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.specialty') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                <path d="M11 3v2" />
                                <path d="M6 3v2" />
                                <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý chuyên khoa</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/sclinic*') || request()->is('system/sclinic?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.sclinic') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-hospital-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 16v-8" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M14 16v-8" />
                                <path d="M10 12h4" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý phòng khám</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('system/medicines*') || request()->is('system/medicines?*') ? 'selected' : '' }}">

                    <a class="sidebar-link" href="{{ route('system.medicine') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
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
                <li class="sidebar-item {{ request()->is('system/medicineType*') || request()->is('system/medicineType?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.medicineType') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
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
                <li class="sidebar-item {{ request()->is('system/account*') || request()->is('system/account?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href=" {{ route('system.account') }}" id="navbarDropdown" role="button"
                        data-bs-toggle="" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý tài khoản</span>
                    </a>

                </li>
                <li class="sidebar-item {{ request()->is('system/schedule*') || request()->is('system/schedule?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.schedule') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M7 14h.013" />
                                <path d="M10.01 14h.005" />
                                <path d="M13.01 14h.005" />
                                <path d="M16.015 14h.005" />
                                <path d="M13.015 17h.005" />
                                <path d="M7.01 17h.005" />
                                <path d="M10.01 17h.005" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý lịch làm BS</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/appointmentSchedule*') || request()->is('system/appointmentSchedule?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.appointmentSchedule') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                <path d="M16 3l0 4" />
                                <path d="M8 3l0 4" />
                                <path d="M4 11l16 0" />
                                <path d="M8 15h2v2h-2z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý lịch khám</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/blog*') || request()->is('system/blog?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.blog') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-news">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
                                <path d="M8 8l4 0" />
                                <path d="M8 12l4 0" />
                                <path d="M8 16l4 0" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bài viết</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/product*') || request()->is('system/product?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.product') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-building-store">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l18 0" />
                                <path
                                    d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                                <path d="M5 21l0 -10.15" />
                                <path d="M19 21l0 -10.15" />
                                <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý sản phẩm </span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/category*') || request()->is('system/category?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.category') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 6l11 0" />
                                <path d="M9 12l11 0" />
                                <path d="M9 18l11 0" />
                                <path d="M5 6l0 .01" />
                                <path d="M5 12l0 .01" />
                                <path d="M5 18l0 .01" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý danh mục SP</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/sale_product*') || request()->is('system/sale_product?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.sale_product') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-badge-vo">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M7 9l2 6l2 -6" />
                                <path
                                    d="M15.5 9a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5z" />
                            </svg>
                        </span>
                        <span class="hide-menu">QL mã giảm giá SP</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/coupon*') || request()->is('system/coupon?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.coupon') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-cash-banknote">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path
                                    d="M3 6m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M18 12l.01 0" />
                                <path d="M6 12l.01 0" />
                            </svg>
                        </span>
                        <span class="hide-menu">QL mã giảm giá</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/order*') || request()->is('system/order?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.order') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-receipt-2"></i>
                        </span>
                        <span class="hide-menu">Quản lý đơn hàng</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system.service') || request()->is('system.service') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.service') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-first-aid-kit"></i>
                        </span>
                        <span class="hide-menu">Quản lý dịch vụ</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/serviceType*') || request()->is('system/serviceType?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.serviceType') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-report-medical"></i>
                        </span>
                        <span class="hide-menu">Quản lý nhóm dịch vụ</span>
                    </a>
                </li>
            </ul>
            </li>
        </nav>
    </div>
</aside>
@else
<aside class="left-sidebar">
    <!-- Cuộn thanh bên - đây là thanh bên cho bác sĩ -->
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
                <li class="sidebar-item {{ request()->is('system/dashboard*') || request()->is('system/serviceType?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.dashboard') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                                <path
                                    d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                            </svg>
                        </span>
                        <span class="hide-menu">Thống kê (Bác sĩ)</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bệnh nhân</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/recordDoctor*') || request()->is('system/recordDoctor?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.recordDoctor') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path
                                    d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M9 12h6" />
                                <path d="M9 16h6" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý bệnh án</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/checkupHealth*') || request()->is('system/checkupHealth?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.checkupHealth') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                <path d="M16 3l0 4" />
                                <path d="M8 3l0 4" />
                                <path d="M4 11l16 0" />
                                <path d="M8 15h2v2h-2z" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý lịch khám</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('system/scheduleDoctor*') || request()->is('system/scheduleDoctor?*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('system.scheduleDoctor') }}" aria-expanded="false">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M7 14h.013" />
                                <path d="M10.01 14h.005" />
                                <path d="M13.01 14h.005" />
                                <path d="M16.015 14h.005" />
                                <path d="M13.015 17h.005" />
                                <path d="M7.01 17h.005" />
                                <path d="M10.01 17h.005" />
                            </svg>
                        </span>
                        <span class="hide-menu">Quản lý lịch làm</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Kết thúc Điều hướng thanh bên -->

    <!-- Kết thúc Cuộn thanh bên -->
</aside>
@endif
@endif