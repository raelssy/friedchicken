<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Menu;
use App\Models\Bahan;

class ResepController extends Controller
{
    // =========================
    // LIST RESEP
    // =========================
    public function index()
    {
        $reseps = \App\Models\Resep::with('menu','bahan')->get();

        // 🔥 PASTIKAN SEMUA DATA VALID
        $reseps = $reseps->filter(function ($r) {
            return $r instanceof \App\Models\Resep;
        });

        // 🔥 GROUP BY MENU
        $reseps = $reseps->groupBy('menu_id');

        return view('resep.index', compact('reseps'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        $menus = Menu::all();
        $bahans = Bahan::all();

        return view('resep.create', compact('menus', 'bahans'));
    }

    // =========================
    // SIMPAN RESEP
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required'
        ]);

        $bahanIds = $request->bahan_id;
        $jumlahs = $request->jumlah;

        $valid = false;

        foreach ($bahanIds as $index => $bahanId) {

            if ($bahanId && $jumlahs[$index]) {

                $valid = true;

                Resep::create([
                    'menu_id' => $request->menu_id,
                    'bahan_id' => $bahanId,
                    'jumlah' => $jumlahs[$index]
                ]);
            }
        }

        // ❌ kalau tidak ada bahan valid
        if (!$valid) {
            return back()->with('error', 'Minimal 1 bahan harus diisi');
        }

        return redirect()->route('resep.index')
            ->with('success', 'Resep berhasil disimpan');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        Resep::destroy($id);

        return back()->with('success', 'Resep berhasil dihapus');
    }
}