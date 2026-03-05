<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Bahan;

class StokController extends Controller
{

    public function index()
{
    $menu = Menu::all(); // Mengambil data stok siap jual
    $bahan = Bahan::all(); // Mengambil data stok mentah (misal nama modelnya Bahan)
    
    return view('stok.index', compact('menu', 'bahan'));
}

    public function create()
    {
        $cabangs = Cabang::all();
        return view('stok.create', compact('cabangs'));
    }

    public function createBahan()
{
    return view('bahan.create');
}

    public function store(Request $request)
    {
        Stok::create($request->all());

        return redirect()->route('stok.index')
        ->with('success','Stok berhasil ditambahkan');
    }

    public function storeBahan(Request $request)
{
    $request->validate([
        'nama_bahan' => 'required|string|max:255',
        'jumlah' => 'required|numeric|min:0',
        'satuan' => 'required|string',
    ]);

    \App\Models\Bahan::create([
        'nama_bahan' => $request->nama_bahan,
        'jumlah' => $request->jumlah,
        'satuan' => $request->satuan,
    ]);

    return back()->with('success', 'Bahan mentah berhasil ditambahkan!');
}
    public function edit(Stok $stok)
    {
        $cabangs = Cabang::all();
        return view('stok.edit', compact('stok','cabangs'));
    }


    // Edit Bahan Mentah
public function editBahan($id) {
    $bahan = Bahan::findOrFail($id);
    return view('bahan.edit', compact('bahan'));
}

// Update Bahan Mentah
public function updateBahan(Request $request, $id) {
    $bahan = Bahan::findOrFail($id);
    $bahan->update($request->all());
    return redirect()->route('stok.index')->with('success', 'Stok bahan berhasil diperbarui!');
}

    public function update(Request $request, Stok $stok)
    {
        $stok->update($request->all());

        return redirect()->route('stok.index')
        ->with('success','Stok berhasil diupdate');
    }

    public function destroy(Stok $stok)
    {
        $stok->delete();

        return redirect()->route('stok.index')
        ->with('success','Stok berhasil dihapus');
    }

}