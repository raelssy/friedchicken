@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h3>Data Stok</h3>

<a href="{{ route('stok.create') }}" class="btn btn-primary mb-3">
Tambah Stok
</a>

<table class="table table-bordered">

<thead>
<tr>
<th>No</th>
<th>Cabang</th>
<th>Nama Bahan</th>
<th>Jumlah</th>
<th>Satuan</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($stoks as $stok)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $stok->cabang->nama_cabang }}</td>
<td>{{ $stok->nama_bahan }}</td>
<td>{{ $stok->jumlah }}</td>
<td>{{ $stok->satuan }}</td>

<td>

<a href="{{ route('stok.edit',$stok->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('stok.destroy',$stok->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection