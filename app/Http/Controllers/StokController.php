<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Bahan;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $menu = Menu::all();
            $bahan = Bahan::all();
            $reseps = Resep::all();
        } else {
            $menu = Menu::where('cabang_id', $user->cabang_id)->get();
            $bahan = Bahan::where('id', $user->cabang_id)->get();
            $reseps = Resep::where('cabang_id', $user->cabang_id)->get();
        }

        return view('stok.index', compact('menu', 'bahan', 'reseps'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view('stok.create', compact('cabangs'));
    }

    public function createBahan()
    {
        $cabangs = \App\Models\Cabang::all();
        return view('bahan.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        Stok::create([
            'nama_bahan' => $request->nama_bahan,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'cabang_id' => Auth::user()->cabang_id
        ]);

        return redirect()->route('stok.index')
        ->with('success','Stok berhasil ditambahkan');
    }

    public function storeBahan(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'cabang_id' => 'required|exists:cabangs,id'
        ]);

        \App\Models\Bahan::create([
            'nama_bahan' => $request->nama_bahan,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'cabang_id' => Auth::user()->cabang_id
        ]);

        return back()->with('success', 'Bahan mentah berhasil ditambahkan!');
    }
    public function edit(Stok $stok)
    {
        $user = Auth::user();

        if ($user->role != 'admin' && $stok->cabang_id != $user->cabang_id) {
            abort(403);
        }

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
        $user = Auth::user();

        if ($user->role != 'admin' && $stok->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $stok->update($request->all());

        return redirect()->route('stok.index')
            ->with('success','Stok berhasil diupdate');
    }

    public function destroy(Stok $stok)
    {
        $user = Auth::user();

        if ($user->role != 'admin' && $stok->cabang_id != $user->cabang_id) {
            abort(403);
        }

        $stok->delete();

        return redirect()->route('stok.index')
            ->with('success','Stok berhasil dihapus');
    }

}