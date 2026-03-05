<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;

class KasirController extends Controller
{

    public function index()
    {
        $transaksi = Transaksi::all();

        return view('kasir.index', compact('transaksi'));
    }


    public function create()
    {
        $menu = Menu::all();

        return view('kasir.create', compact('menu'));
    }


    public function store(Request $request)
    {
        Transaksi::create([
            'menu_id' => $request->menu_id,
            'qty' => $request->qty,
            'total' => $request->total
        ]);

        return redirect()->route('kasir.index');
    }


    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menu = Menu::all();

        return view('kasir.edit', compact('transaksi','menu'));
    }


    public function update(Request $request,$id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'menu_id'=>$request->menu_id,
            'qty'=>$request->qty,
            'total'=>$request->total
        ]);

        return redirect()->route('kasir.index');
    }

}