<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Cabang;
use App\Models\Resep;
use App\Models\Bahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
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

    public function create()
    {
        $cabangs = Cabang::all();
        return view('menu.create', compact('cabangs'));
    }

    public function store(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nama_menu' => 'required|string|max:255',
        'harga' => 'required|integer|min:0',
        'kategori' => 'required|string',
        'cabang_id' => 'nullable',
        'gambar' => 'nullable|image|max:10240' 
    ]);

    $cabangId = $user->role == 'admin'
        ? $request->cabang_id
        : $user->cabang_id;

    if (!$cabangId) {
        return back()->with('error', 'Cabang wajib dipilih');
    }

    // 🔥 HANDLE UPLOAD GAMBAR
    $gambar = null;
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar')->store('menu', 'public');
    }

    Menu::create([
        'nama_menu' => $request->nama_menu,
        'harga' => $request->harga,
        'kategori' => $request->kategori,
        'stok' => 0,
        'cabang_id' => $cabangId,
        'gambar' => $gambar 
    ]);

    return redirect()->route('menu.index')
        ->with('success', 'Menu berhasil ditambahkan');
}
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

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' &&
            $menu->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }

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
    // UPDATE STOK (FIX FINAL)
    // =========================
    public function updateStok(Request $request, $id)
    {
        $jumlahInput = (float) $request->stok;

        $menu = Menu::findOrFail($id);

        $reseps = Resep::where('menu_id', $id)->get();

        $resepUtama = $reseps->where('is_main', 1)->first();

        if (!$resepUtama) {
            return back()->with('error', 'Bahan utama belum diset');
        }

        $utama = (float) $resepUtama->jumlah;

        // =========================
        // 🔥 STEP 1: CEK DULU SEMUA BAHAN
        // =========================
        foreach ($reseps as $resep) {

            $bahan = Bahan::find($resep->bahan_id);

            if (!$bahan) continue;

            if ($resep->is_main) {
                $kurang = $jumlahInput;
            } else {
                $kurang = ($resep->jumlah / $utama) * $jumlahInput;
            }

            // ❌ JIKA TIDAK CUKUP
            if ($bahan->jumlah < $kurang) {
                return back()->with('error', 
                    'Stok bahan "' . $bahan->nama_bahan . '" tidak cukup!'
                );
            }
        }

        // =========================
        // 🔥 STEP 2: BARU KURANGI
        // =========================
        DB::beginTransaction();

        try {

            foreach ($reseps as $resep) {

                $bahan = Bahan::find($resep->bahan_id);

                if (!$bahan) continue;

                if ($resep->is_main) {
                    $kurang = $jumlahInput;
                } else {
                    $kurang = ($resep->jumlah / $utama) * $jumlahInput;
                }

                $bahan->jumlah -= $kurang;
                $bahan->save();
            }

            // 🔥 tambah stok menu
            $menu->stok += $jumlahInput;
            $menu->save();

            DB::commit();

            return back()->with('success', 'Stok berhasil ditambahkan 🔥');

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan!');
        }
    }
}