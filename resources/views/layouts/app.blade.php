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

    <!--  Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>