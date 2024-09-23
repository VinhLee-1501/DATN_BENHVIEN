@extends('layouts.client.app')

@section('meta_title', 'Trang hồ sơ')

@section('content')

    <div class="main-body">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-nav">
                    <div class="item"><a href="https://phongkhamtuean.com.vn" title="Trang chủ">Trang chủ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">Lịch sử</div>
                </div>
            </div>
        </div>
        <div class="profile__page">
            <div class="container">
                <div class="profile__page--frame">
                    <div class="row gap-y-40">

                        <div class="col l-4 mc-12 c-12">
                            <div class="profile__info">

                                <div class="profile__avatar">
                                    <img src="{{ auth()->user()->avarta }}" alt="Avatar" />
                                </div>
                                <h1 class="text-center">Thông tin cá nhân</h1>
                                <div class="profile__details">
                                    <p><strong>Họ tên:</strong> {{ auth()->user()->name }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ auth()->user()->phone }} </p>
                                    <p><strong>Email:</strong>{{ auth()->user()->email }}</p>
                                    <p><strong>Ngày sinh:</strong> 01/01/1990</p>
                                    <p><strong>Địa chỉ:</strong>
                                        @if (empty(auth()->user()->address))
                                            Chưa cập nhật
                                        @else
                                            {{ auth()->user()->address }}
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('client.logout') }}"><button style="border:none" class="button btn-small btn-cta">Đăng
                                        xuất</button></a>
                            </div>

                        </div>

                        <div class="col l-8 mc-12 c-12">
                            <div class="profile__medical-history">
                                <h1 class="text-center">Lịch sử khám bệnh</h1>
                                <table class="medical-history__table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày</th>
                                            <th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>15/08/2024</td>
                                            <td>Kháng sinh</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>15/08/2024</td>
                                            <td>Thuốc giảm đau</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
