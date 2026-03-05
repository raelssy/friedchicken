@extends('layouts.app')

@section('content')

<h3>Edit Transaksi</h3>

<form action="/kasir/update/{{ $transaksi->id }}" method="POST">

@csrf

<div class="mb-3">

<label>Menu</label>

<select name="menu_id" class="form-control">

@foreach($menu as $m)

<option value="{{ $m->id }}"
{{ $transaksi->menu_id == $m->id ? 'selected' : '' }}>

{{ $m->nama_menu }} - Rp {{ number_format($m->harga) }}

</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Jumlah</label>

<input type="number" name="qty" class="form-control"
value="{{ $transaksi->qty }}">

</div>


<div class="mb-3">

<label>Total</label>

<input type="number" name="total" class="form-control"
value="{{ $transaksi->total }}">

</div>


<button class="btn btn-primary">
Update
</button>

</form>

@endsection