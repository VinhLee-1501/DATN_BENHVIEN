@extends('layouts.admin.master')
@section('title', 'Quản lý tài khoản')
@section('content')

<nav class="mb-3">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link {{ $activeTab == 'nav-home' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
            onclick="window.location='?tab=nav-home'">Quản trị
        </button>
        <button class="nav-link {{ $activeTab == 'nav-contact' ? 'active' : '' }}" id="nav-contact-tab"
            data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
            aria-selected="false" onclick="window.location='?tab=nav-contact'">Bệnh nhân
        </button>
        <button class="nav-link {{ $activeTab == 'nav-staff' ? 'active' : '' }}" id="nav-staff-tab"
            data-bs-toggle="tab" data-bs-target="#nav-staff" type="button" role="tab" aria-controls="nav-staff"
            aria-selected="false" onclick="window.location='?tab=nav-staff'">Nhân viên
        </button>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">

    <form action="{{ route('system.account') }}" method="GET" class="row mb-3 g-2 align-items-center" id="searchForm">
        <div class="col-md-8 ">
            <div class="row g-2  align-items-center">
                <div class="col-md-4 col-12 ">
                    <input type="text" id="lastnameInput" class="form-control" placeholder="Tìm theo Họ" name="lastname"
                        value="{{ request('lastname') }}">
                </div>
                <div class="col-md-4 col-12 ">
                    <input type="text" id="firstnameInput" class="form-control" placeholder="Tìm theo Tên"
                        name="firstname" value="{{ request('firstname') }}">
                </div>
                <div class="col-md-4 col-12 ">
                    <input type="text" id="phoneInput" class="form-control" placeholder="Tìm theo SĐT" name="phone"
                        value="{{ request('phone') }}">
                </div>
            </div>
        </div>
        <div class="col-md-4  ">
            <div class="row g-2  align-items-center">
                <div class="col-md-6 col-12">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
                <div class="col-md-6 col-12">
                    <a href="{{ route('system.accounts.create') }}" class="btn btn-success w-100">Thêm Tài Khoản</a>
                </div>
            </div>
        </div>

        <!-- Đảm bảo tab hiện tại được giữ lại trong URL -->
        <input type="hidden" name="tab" value="{{ request('tab', 'nav-home') }}">
    </form>


    <div class="tab-pane fade show {{ $activeTab == 'nav-home' ? 'show active' : '' }}" id="nav-home" role="tabpanel"
        aria-labelledby="nav-home-tab">
        @include('System.accounts.admin', ['admin' => $admin]) <!-- Truyền biến admin vào view -->
    </div>

    <div class="tab-pane fade {{ $activeTab == 'nav-contact' ? 'show active' : '' }}" id="nav-contact" role="tabpanel"
        aria-labelledby="nav-contact-tab">
        @include('System.accounts.users', ['users' => $users]) <!-- Truyền biến users vào view -->
    </div>

    <div class="tab-pane fade {{ $activeTab == 'nav-staff' ? 'show active' : '' }}" id="nav-staff" role="tabpanel"
        aria-labelledby="nav-staff-tab">
        @include('System.accounts.staff', ['staff' => $staff]) <!-- Truyền biến users vào view -->
    </div>

</div>

@endsection