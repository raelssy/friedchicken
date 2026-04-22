<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FnB Fried Chicken</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- 🔥 SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Style Global -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Montserrat', sans-serif;
        }

        .main-wrapper {
            max-width: 1400px;
            margin: auto;
        }

        /* 🔥 Custom Popup Style */
        .swal2-popup {
            border-radius: 20px !important;
            padding: 20px !important;
        }

        .swal2-title {
            font-weight: 800 !important;
        }

        .swal2-confirm, .swal2-cancel {
            border-radius: 8px !important;
            padding: 8px 16px;
            font-weight: 600;
        }
    </style>

    @stack('styles')

</head>

<body>

    @include('layouts.navigation')

    <div class="container-fluid mt-4 px-4">
        <div class="main-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- ========================= -->
    <!-- 🔥 POPUP NOTIFICATION -->
    <!-- ========================= -->

    @if(session('error'))
    <script>
    Swal.fire({
        title: 'Gagal!',
        text: `{!! session('error') !!}`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Coba Lagi',
        cancelButtonText: 'Tutup',
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#ef4444'
    }).then((result) => {

        // 🔁 tetap di form
        if (result.isConfirmed) {
            return;
        }

        // 🔥 balik ke kelola stok
        window.location.href = "{{ route('stok.index') }}";

    });
    </script>
    @endif

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#22c55e',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>