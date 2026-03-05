<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Cabang;

class StokController extends Controller
{

    public function index()
    {
        $stoks = Stok::with('cabang')->get();
        return view('stok.index', compact('stoks'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view('stok.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        Stok::create($request->all());

        return redirect()->route('stok.index')
        ->with('success','Stok berhasil ditambahkan');
    }

    public function edit(Stok $stok)
    {
        $cabangs = Cabang::all();
        return view('stok.edit', compact('stok','cabangs'));
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