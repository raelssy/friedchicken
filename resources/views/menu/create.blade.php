@extends('layouts.app')

@section('content')

<div class="container">

<h3>Tambah Menu</h3>

<form action="{{ route('menu.store') }}" method="POST">
@csrf

<div class="mb-3">
<label>Nama Menu</label>
<input type="text" name="nama_menu" class="form-control" required>
</div>

<div class="mb-3">
<label>Harga</label>
<input type="number" name="harga" class="form-control" required>
</div>

<div class="mb-3">
<label>Kategori</label>

<select name="kategori" class="form-control">
<option value="Makanan">Makanan</option>
<option value="Minuman">Minuman</option>
<option value="Paket">Paket</option>
</select>

</div>

<button class="btn btn-success">
Simpan
</button>

<a href="{{ route('menu.index') }}" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

@endsection