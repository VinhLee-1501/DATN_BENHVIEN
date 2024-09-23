<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('backend/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <x-admin.Sidebar></x-admin.Sidebar>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <x-admin.Header></x-admin.Header>
            <!--  Header End -->
            <div class="container-fluid">
                <!--  Row 1 -->
                @yield('content')
                <x-admin.Footer></x-admin.Footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <x-message.message></x-message.message>
</body>

</html>
