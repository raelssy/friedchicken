<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{

    public function index()
    {
        $menu = Menu::all();
        return view('menu.index', compact('menu'));
    }

    public function create()
    {
        return view('menu.create');
    }

        public function store(Request $request)
{
    Menu::create([
        'nama_menu' => $request->nama_menu,
        'harga' => $request->harga,
        'kategori' => $request->kategori
    ]);

    return redirect()->route('menu.index');
}

    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->update($request->all());

        return redirect('/menu');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect('/menu');
    }

}