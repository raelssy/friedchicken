@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h3>Tambah Stok</h3>

<form action="{{ route('stok.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Cabang</label>

<select name="cabang_id" class="form-control">

@foreach($cabangs as $cabang)

<option value="{{ $cabang->id }}">
{{ $cabang->nama_cabang }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">
<label>Nama Bahan</label>
<input type="text" name="nama_bahan" class="form-control">
</div>

<div class="mb-3">
<label>Jumlah</label>
<input type="number" name="jumlah" class="form-control">
</div>

<div class="mb-3">
<label>Satuan</label>
<input type="text" name="satuan" class="form-control">
</div>

<button class="btn btn-success">Simpan</button>

</form>

</div>

@endsection