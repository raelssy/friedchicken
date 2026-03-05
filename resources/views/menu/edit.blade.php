@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Menu</h3>

<form action="{{ route('menu.update',$menu->id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-3">
<label class="form-label">Nama Menu</label>
<input type="text"
       name="nama_menu"
       class="form-control"
       value="{{ $menu->nama_menu }}">
</div>

<div class="mb-3">
<label class="form-label">Harga</label>
<input type="number"
       name="harga"
       class="form-control"
       value="{{ $menu->harga }}">
</div>

<div class="mb-3">
<label class="form-label">Kategori</label>

<select name="kategori" class="form-control">

<option value="Makanan" {{ $menu->kategori == "Makanan" ? "selected" : "" }}>
Makanan
</option>

<option value="Minuman" {{ $menu->kategori == "Minuman" ? "selected" : "" }}>
Minuman
</option>

<option value="Paket" {{ $menu->kategori == "Paket" ? "selected" : "" }}>
Paket
</option>

</select>

</div>

<button class="btn btn-primary">
Update
</button>

<a href="{{ route('menu.index') }}" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

@endsection