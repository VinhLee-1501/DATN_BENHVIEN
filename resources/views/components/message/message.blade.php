
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @elseif (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @elseif (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
