<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{

    public function index()
    {
        $cabang = Cabang::all();
        return view('cabang.index', compact('cabang'));
    }

    public function create()
    {
        return view('cabang.create');
    }

    public function store(Request $request)
    {
        Cabang::create($request->all());
        return redirect('/cabang');
    }

    public function edit($id)
    {
        $cabang = Cabang::find($id);
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request, $id)
    {
        $cabang = Cabang::find($id);
        $cabang->update($request->all());

        return redirect('/cabang');
    }

    public function destroy($id)
    {
        Cabang::destroy($id);
        return redirect('/cabang');
    }

}