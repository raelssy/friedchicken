<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // =========================
    // LIST MENU
    // =========================
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $menu = Menu::all();
        } else {
            $menu = Menu::where('cabang_id', $user->cabang_id)->get();
        }

        return view('menu.index', compact('menu'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        $cabangs = Cabang::all(); // 🔥 untuk dropdown
        return view('menu.create', compact('cabangs'));
    }

    // =========================
    // STORE MENU (FIX TOTAL)
    // =========================
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'cabang_id' => 'nullable' // admin pakai ini
        ]);

        // 🔥 LOGIC CERDAS
        $cabangId = $user->role == 'admin'
            ? $request->cabang_id
            : $user->cabang_id;

        // 🔥 VALIDASI TAMBAHAN
        if (!$cabangId) {
            return back()->with('error', 'Cabang wajib dipilih');
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'stok' => 0,
            'cabang_id' => $cabangId
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    // =========================
    // EDIT MENU
    // =========================
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        return view('menu.edit', compact('menu'));
    }

    // =========================
    // UPDATE MENU
    // =========================
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kategori' => 'required|string',
        ]);

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diupdate');
    }

    // =========================
    // DELETE MENU
    // =========================
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }

    // =========================
    // FORM TAMBAH STOK
    // =========================
    public function editStok($id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        return view('menu.stok', compact('menu'));
    }

    // =========================
    // UPDATE STOK
    // =========================
    public function updateStok(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $menu->stok += $request->stok;
        $menu->save();

        return redirect()->route('stok.index')
            ->with('success', 'Stok menu berhasil ditambahkan');
    }
}