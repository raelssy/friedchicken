@extends('layouts.app')

@section('content')

<h3>POS / Kasir</h3>

<a href="{{ route('kasir.create') }}" class="btn btn-primary mb-3">
    Transaksi Baru
</a>

<table class="table table-bordered">

<thead>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($transaksi as $t)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $t->created_at }}</td>

<td>Rp {{ number_format($t->total) }}</td>

<td>

<a href="/kasir/edit/{{ $t->id }}" class="btn btn-warning btn-sm">
Edit
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection