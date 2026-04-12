<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses register (hanya admin)
     */
    public function store(Request $request): RedirectResponse
    {
        // 🔐 Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        // 🔥 Buat user sebagai ADMIN
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',      // 🔥 penting
            'cabang_id' => null     // admin tidak punya cabang
        ]);

        // 🔑 Auto login setelah register
        Auth::login($user);

        // 🔁 Redirect ke dashboard
        return redirect()->route('dashboard')
            ->with('success', 'Admin berhasil dibuat!');
    }
}