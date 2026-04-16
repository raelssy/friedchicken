<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth as AuthFacade;

class MenuController extends Controller
{
    // =========================
    // LIST MENU
    // =========================
    public function index()
    {
        $user = AuthFacade::user();

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
        return view('menu.create');
    }

    // =========================
    // STORE MENU
    // =========================
    public function store(Request $request)
    {
        $user = AuthFacade::user();

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:255',
        ]);

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'stok' => 0,
            'cabang_id' => $user->cabang_id
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT MENU
    // =========================
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $user = AuthFacade::user();

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
        $user = AuthFacade::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:255',
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
        $user = AuthFacade::user();

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
        $user = AuthFacade::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        return view('menu.stok', compact('menu'));
    }

    // =========================
    // UPDATE STOK (TAMBAH)
    // =========================
    public function updateStok(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $user = AuthFacade::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        // 🔥 tambah stok (bukan replace)
        $menu->stok += $request->stok;
        $menu->save();

        return redirect()->route('stok.index')
            ->with('success', 'Stok menu berhasil ditambahkan');
    }
}