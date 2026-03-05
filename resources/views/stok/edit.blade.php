@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h3>Edit Stok</h3>

<form action="{{ route('stok.update',$stok->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Cabang</label>

<select name="cabang_id" class="form-control">

@foreach($cabangs as $cabang)

<option value="{{ $cabang->id }}"
{{ $stok->cabang_id == $cabang->id ? 'selected' : '' }}>

{{ $cabang->nama_cabang }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">
<label>Nama Bahan</label>
<input type="text" name="nama_bahan"
value="{{ $stok->nama_bahan }}"
class="form-control">
</div>

<div class="mb-3">
<label>Jumlah</label>
<input type="number" name="jumlah"
value="{{ $stok->jumlah }}"
class="form-control">
</div>

<div class="mb-3">
<label>Satuan</label>
<input type="text" name="satuan"
value="{{ $stok->satuan }}"
class="form-control">
</div>

<button class="btn btn-success">
Update
</button>

</form>

</div>

@endsection