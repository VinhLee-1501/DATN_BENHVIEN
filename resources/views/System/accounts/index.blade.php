@extends('layouts.admin.master')
@section('title', 'Quản lý tài khoản')
@section('content')
   <style>
    .nav-tabs .nav-link {
        color: #000000 !important;
    }
    
   </style>
    <nav class="mb-3">
        <div class="nav nav-tabs gap-3" id="nav-tab" role="tablist">
            <button class="nav-link active bg-danger" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Quản trị
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Bác sĩ
            </button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Người dùng
            </button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="col-md-12 row">
            <div class="col-md-6 d-flex">
                <form action="" class="col-md-12 row">
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nameInput" class="form-control" placeholder="Tìm theo Họ tên" name="name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="phoneInput" class="form-control" placeholder="Tìm theo SDT" name="phone">
                    </div>
                </form>
            </div>
            <div class="col-md-6 mb-3">
                <a href="{{ route('system.accounts.create') }}" class="btn btn-success me-2">Thêm Tài Khoản</a>
            </div>
        </div>

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            @include('System.accounts.admin')
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            @include('System.accounts.doctors')
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            @include('System.accounts.users')
        </div>

        <div id="noResults" class="alert alert-warning" style="display: none;">Không tìm thấy dữ liệu.</div>

    </div>

    <script>
    $(document).ready(function () {
        $("#phoneInput, #nameInput").on("keyup", function () {
            var nameValue = $("#nameInput").val().toLowerCase();
            var phoneValue = $("#phoneInput").val().toLowerCase();
            var found = false;

            $("#myTable tr").each(function () {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(nameValue) > -1 && rowText.indexOf(phoneValue) > -1) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });

            if (!found) {
                $("#noResults").show(); // Ensure there's an element with ID 'noResults' for this to work
            } else {
                $("#noResults").hide();
            }
        });
    });
</script>


    <script>
        // Set background color for active tabs
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('#nav-tab .nav-link');

            function updateTabColors(activeTab) {
                tabs.forEach(tab => {
                    tab.classList.remove('bg-danger', 'bg-success', 'bg-primary');
                });

                switch (activeTab.id) {
                    case 'nav-home-tab':
                        activeTab.classList.add('bg-danger');
                        break;
                    case 'nav-profile-tab':
                        activeTab.classList.add('bg-success');
                        break;
                    case 'nav-contact-tab':
                        activeTab.classList.add('bg-primary');
                        break;
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('show.bs.tab', function () {
                    updateTabColors(tab);
                });
            });
        });
    </script>
@endsection
