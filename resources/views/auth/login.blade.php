<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-100 to-orange-300 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    <h2 class="text-2xl font-bold text-center text-orange-600 mb-2">
        🍗 Fried Chicken POS
    </h2>
    <p class="text-center text-gray-500 mb-6">
        Login Admin / Cabang
    </p>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

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

        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg transition">
            Login
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-orange-600 font-semibold">Register</a>
    </p>

</div>

</body>
</html>