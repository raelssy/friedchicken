@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">
    <h3>Data Menu</h3>

    <a href="{{ route('menu.create') }}" class="btn btn-primary">
        Tambah Menu
    </a>
</div>

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>No</th>
<th>Nama Menu</th>
<th>Harga</th>
<th>Kategori</th>
<th width="200">Aksi</th>
</tr>
</thead>

<tbody>

@foreach($menu as $index => $m)

<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $m->nama_menu }}</td>
<td>Rp {{ number_format($m->harga) }}</td>
<td>{{ $m->kategori }}</td>

<td class="d-flex gap-2">

<a href="{{ route('menu.edit',$m->id) }}" 
   class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('menu.destroy',$m->id) }}" 
      method="POST"
      onsubmit="return confirm('Yakin hapus menu?')">

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