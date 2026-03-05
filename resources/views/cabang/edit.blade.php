@extends('layouts.app')

@section('content')

<h3>Edit Cabang</h3>

<form action="/cabang/update/{{ $cabang->id }}" method="POST">
@csrf

<div class="mb-3">
    <label class="form-label">Nama Cabang</label>
    <input type="text" 
           name="nama_cabang" 
           class="form-control"
           value="{{ $cabang->nama_cabang }}">
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" 
              class="form-control" 
              rows="3">{{ $cabang->alamat }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Telepon</label>
    <input type="text" 
           name="telepon"
           class="form-control"
           value="{{ $cabang->telepon }}">
</div>

<button class="btn btn-primary">
    Update
</button>

<a href="/cabang" class="btn btn-secondary">
    Kembali
</a>

</form>

@endsection