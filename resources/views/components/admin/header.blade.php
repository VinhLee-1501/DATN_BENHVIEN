<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mx-3">
                            @if (auth()->user()->role == 1)
                                <div class="badge bg-danger">
                                    Quản trị viên
                                </div>
                            @elseif (auth()->user()->role == 2)
                                <div class="badge bg-success">
                                    Tài khoản bác sĩ
                                </div>
                            @endif

                        </span>
                        <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <div class="d-flex justify-content-center align-items-center gap-2 p-2">
                                <span class="badge bg-primary">{{ Auth::user()->firstname }}
                                    {{ Auth::user()->lastname }}</span>
                            </div>
                            <a href="{{ route('system.profile') }}"
                                class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Thông tin tài khoản</p>
                            </a>
                            <a href="{{ route('system.change-password') }}"
                                class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-key fs-6"></i>
                                <p class="mb-0 fs-3">Đổi mật khẩu</p>
                            </a>
                            <a href="{{ route('system.auth.logout') }}"
                                class="btn btn-outline-primary mx-3 mt-2 d-block">Đăng xuất</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
