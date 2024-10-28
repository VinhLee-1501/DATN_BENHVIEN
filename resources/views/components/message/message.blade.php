<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @elseif (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @elseif (session('error'))
        toastr.error("{{ session('error') }}");
    @elseif (session('info_success'))
        toastr.success("{{ session('info_success') }}");
    @elseif (session('info_error'))
        toastr.error("{{ session('info_error') }}");
    @elseif (session('change_password_success'))
        toastr.success("{{ session('change_password_success') }}");
    @elseif (session('change_password_error'))
        toastr.error("{{ session('change_password_error') }}");
    @endif
</script>
