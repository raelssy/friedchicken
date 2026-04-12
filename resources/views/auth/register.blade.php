<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-100 to-orange-300 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    <h2 class="text-2xl font-bold text-center text-orange-600 mb-2">
        🍗 Register Admin
    </h2>
    <p class="text-center text-gray-500 mb-6">
        Buat akun admin pertama
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="text-sm text-gray-600">Nama</label>
            <input type="text" name="name"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-orange-400"
                required>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Email</label>
            <input type="email" name="email"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-orange-400"
                required>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-orange-400"
                required>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-orange-400"
                required>
        </div>

        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg transition">
            Register
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-orange-600 font-semibold">Login</a>
    </p>

</div>

</body>
</html>