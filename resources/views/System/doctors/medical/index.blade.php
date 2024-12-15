@extends('layouts.admin.master')
@section('content')
    @if (session()->has('pdf_data'))
        <script>
            window.onload = function() {
                window.open("{{ route('system.downloadPdf') }}", '_blank');
            };
        </script>
    @endif
    <!-- Tab nav -->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Đang khám</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Đã khám</button>
        </div>
    </nav>

    <!-- Tab content -->
    <div class="tab-content" id="nav-tabContent">

        <form action="" method="GET" class="mb-3 row g-2 justify-content-between align-items-center">
            <div class="row g-2 justify-content-center align-items-center col-md-5">
                <div class="col-md-6 col-sm-6">

                    <input type="text" id="nameInput" class="form-control" placeholder="Tên bệnh nhân" name="lastname"
                        value="{{ request('lastname') }}">

                </div>

                <div class="col-md-6 col-sm-6">

                    <input type="text" id="phoneInput" class="form-control" placeholder="Số điện thoại" name="firstname"
                        value="{{ request('phone') }}">

                </div>
            </div>

            <div class="col-md-2 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
        </form>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <!-- Thuốc hoạt động -->
            @include('System.doctors.medical.examined', ['medicalRecord' => $medicalRecord])
        </div>

        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- Thuốc hết -->
            @include('System.doctors.medical.examining', ['medicalRecording' => $medicalRecording])
        </div>
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
