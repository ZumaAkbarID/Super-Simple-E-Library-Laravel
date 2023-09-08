<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "{!! implode('', $errors->all('<div>:message</div>')) !!}"
        });
        $('.swal2-select').addClass('d-none');
    @endif
    @if (session()->has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "{!! session('error') !!}"
        });
        $('.swal2-select').addClass('d-none');
    @endif
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html: "{!! session('success') !!}"
        });
    @endif
    @if (session()->has('info'))
        Swal.fire({
            icon: 'info',
            title: 'Perhatian',
            html: "{!! session('info') !!}"
        });
    @endif
</script>
