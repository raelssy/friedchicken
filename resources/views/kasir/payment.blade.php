@extends('layouts.app')

@section('content')

<div class="container text-center mt-5">

    <h3>💳 Pembayaran</h3>

    <div class="alert alert-info mt-4">
        Anda akan diarahkan ke halaman pembayaran DOKU...
    </div>

    <a href="{{ route('kasir.index') }}" class="btn btn-primary mt-3">
        Kembali ke Kasir
    </a>

</div>

@endsection