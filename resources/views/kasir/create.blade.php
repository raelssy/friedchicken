@extends('layouts.app')

@section('content')

<h3>Transaksi Kasir</h3>

<form action="{{ route('kasir.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Menu</label>

<select name="menu_id" class="form-control">

@foreach($menu as $m)

<option value="{{ $m->id }}">
{{ $m->nama_menu }} - Rp {{ number_format($m->harga) }}
</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Jumlah</label>

<input type="number" name="qty" class="form-control">

</div>


<div class="mb-3">

<label>Total</label>

<input type="number" name="total" class="form-control">

</div>


<button class="btn btn-success">
Simpan Transaksi
</button>

</form>

@endsection