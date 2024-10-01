@extends('layouts.admin.master')
@section('Quản lý tài khoản')
@section('content')

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Quản trị</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Bác sĩ</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Người dùng</button>
        </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">

        <div class="col-md-6 d-flex py-3">
            <form action="" class="col-md-12 row">
                <div class="col-md-6">
                    <input type="text" id="nameInput" class="form-control" placeholder="Tìm theo Họ tên" name="name">
                </div>
                <div class="col-md-6">
                    <input type="text" id="phoneInput" class="form-control" placeholder="Tìm theo SDT" name="phone">
                </div>

            </form>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.accounts.create') }}" class="btn btn-success me-2">Thêm Tài Khoản</a>
        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

           @include(('admin.accounts.admin'))
        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('admin.accounts.doctors')

        </div>


        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            @include('admin.accounts.users')
        </div>
    </div>


    <script>
        $(document).ready(function(){
            $("#phoneInput, #nameInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
