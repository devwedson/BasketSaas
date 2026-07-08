@push('styles')
<link href="{{ attex_asset('assets/css/sweetalert-attex.css') }}" rel="stylesheet" type="text/css">
@endpush

@php
    $dashboardFlash = [
        'success' => session('success'),
        'warning' => session('warning'),
        'errors' => $errors->any() ? $errors->all() : [],
    ];
@endphp
<script>
    window.__dashboardFlash = @json($dashboardFlash);
</script>
<script src="{{ attex_asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ attex_asset('assets/js/dashboard-alerts.js') }}"></script>