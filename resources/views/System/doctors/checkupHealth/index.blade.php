@extends('layouts.admin.master')
@section('content')
    <!-- Tab nav -->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Trực tiếp</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Trực tuyến</button>
        </div>
    </nav>
    <!-- Form tìm kiếm -->
    <form action="{{ route('system.checkupHealth') }}" method="GET" class="row g-2 py-3">
        <div class="col-md-8">
            <div class="row g-2">
                <div class="col-md-4 col-12">
                    <input type="text" id="nameInput" class="form-control" placeholder="Tên bệnh nhân" name="name"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-4 col-12">
                    <input type="text" id="phoneInput" class="form-control" placeholder="Số điện thoại" name="name"
                        value="{{ request('phone') }}">
                </div>
            </div>
        </div>
    </form>

    <!-- Tab content -->
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <!-- Thuốc hoạt động -->
            @include('System.doctors.checkupHealth.offline', ['offline' => $offline])
        </div>

        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- Thuốc hết -->
            @include('System.doctors.checkupHealth.online', ['online' => $online])
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#phoneInput, #nameInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
