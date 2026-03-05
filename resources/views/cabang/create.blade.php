@extends('layouts.app')

@section('content')

<h3>Tambah Cabang</h3>

<form action="/cabang/store" method="POST">
@csrf

<div class="mb-3">
    <label class="form-label">Nama Cabang</label>
    <input type="text" name="nama_cabang" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control" rows="3"></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Telepon</label>
    <input type="text" name="telepon" class="form-control">
</div>

<button class="btn btn-success">
    Simpan
</button>

<a href="/cabang" class="btn btn-secondary">
    Kembali
</a>

</form>

@endsection