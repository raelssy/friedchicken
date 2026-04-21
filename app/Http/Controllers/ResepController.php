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
        $mainBahanId = $request->main_bahan;

        foreach ($request->bahan as $item) {

            if (empty($item['bahan_id'])) continue;

            Resep::create([
                'menu_id' => $request->menu_id,
                'bahan_id' => $item['bahan_id'],
                'jumlah' => $item['jumlah'],
                'is_main' => $item['bahan_id'] == $mainBahanId ? 1 : 0
            ]);
        }

        return redirect()->route('resep.index');
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