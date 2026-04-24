@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: #f5f5f5;
    }

    .container-cart {
        max-width: 1100px;
        margin: 30px auto;
    }

    .grid-cart {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .card-menu {
        background: #fff;
        border-radius: 16px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .card-menu:hover {
        transform: translateY(-5px);
    }

    .card-menu img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
    }

    .menu-title {
        font-weight: 700;
        margin-top: 10px;
    }

    .menu-price {
        color: #ff6600;
        font-weight: 600;
    }

    .qty {
        margin-top: 5px;
    }

    .btn-hapus {
        background: red;
        color: #fff;
        border: none;
        padding: 6px 10px;
        border-radius: 8px;
        margin-top: 10px;
        cursor: pointer;
    }

    .checkout-box {
        margin-top: 30px;
        text-align: right;
    }

    .btn-checkout {
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
    }
</style>

<div class="container-cart">

    <h3>🛒 Keranjang Saya</h3>

    @if($cart->isEmpty())
        <p>Keranjang kosong</p>
    @else

    <div class="grid-cart">
        @foreach($cart as $item)
        <div class="card-menu">

            <img src="{{ asset('storage/'.$item->menu->gambar) }}" alt="">

            <div class="menu-title">
                {{ $item->menu->nama_menu }}
            </div>

            <div class="menu-price">
                Rp {{ number_format($item->menu->harga) }}
            </div>

            <div class="qty">
                Qty: {{ $item->qty }}
            </div>

            <form action="{{ route('cart.remove', $item->id) }}" method="GET">
                <button class="btn-hapus">Hapus</button>
            </form>

        </div>
        @endforeach
    </div>

    <div class="checkout-box">
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <button class="btn-checkout">Checkout</button>
        </form>
    </div>

    @endif

</div>
@endsection