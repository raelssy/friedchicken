@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    background-color: #f4f7f6;
    font-family: 'Montserrat', sans-serif;
}

/* CARD */
.card-kasir {
    border-radius: 20px;
    border: none;
}

/* HEADER */
.card-header-kfc {
    background: linear-gradient(135deg, #e4002b, #b30022);
    color: white;
    padding: 20px;
    border-bottom: 5px solid #ffc107;
}

/* FORM */
.input-kfc {
    border-radius: 10px;
    border: 2px solid #eee;
    padding: 10px;
}

/* MENU GRID */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px,1fr));
    gap: 12px;
}

.menu-card {
    background: #fff;
    border-radius: 12px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}

.menu-card img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
}

/* CART */
.cart-box {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}
</style>

<div class="container py-4">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-kasir shadow-lg">
        <div class="card-header card-header-kfc text-center">
            <h4>POS - KASIR</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <!-- 🔥 MENU -->
                <div class="col-md-7">
                    <h5>🍗 Menu</h5>

                    <div class="menu-grid">
                        @foreach($menu as $m)
                        <div class="menu-card">

                            <img src="{{ $m->gambar ? asset('storage/'.$m->gambar) : 'https://via.placeholder.com/150' }}">

                            <b>{{ $m->nama_menu }}</b>
                            <small>Rp {{ number_format($m->harga) }}</small>

                            <a href="{{ route('cart.add', $m->id) }}" class="btn btn-primary btn-sm mt-2 w-100">
                                + Tambah
                            </a>

                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- 🔥 CART + FORM -->
                <div class="col-md-5">

                    <!-- CART -->
                    <div class="cart-box mb-3">
                        <h5>🛒 Keranjang</h5>

                        @php $total = 0; @endphp

                        @forelse($cart ?? [] as $item)
                            @php 
                                $subtotal = $item->menu->harga * $item->qty;
                                $total += $subtotal;
                            @endphp

                            <div class="border-bottom mb-2 pb-2">
                                <b>{{ $item->menu->nama_menu }}</b><br>
                                Qty: {{ $item->qty }} <br>
                                Rp {{ number_format($subtotal) }}

                                <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-danger btn-sm mt-1">
                                    Hapus
                                </a>
                            </div>
                        @empty
                            <p class="text-muted">Keranjang kosong</p>
                        @endforelse

                        <hr>

                        <h5>Total: Rp {{ number_format($total) }}</h5>

                         <form action="{{ route('checkout') }}" method="POST">
                        @csrf

                        <!-- 🔥 PILIH PEMBAYARAN -->
                        <div class="mb-2">
                            <label class="fw-bold small">Metode Pembayaran</label>

                            <select name="metode_pembayaran" class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>

                        <button class="btn btn-success w-100 mt-2">
                            Checkout
                        </button>
                    {{-- </form>
                            @csrf
                            <button class="btn btn-success w-100 mt-2">
                                Checkout
                            </button>
                        </form> --}}
                    </div>

                    <!-- FORM MANUAL (TETAP ADA) -->
                    <div class="cart-box">
                        <h6>Manual Input</h6>

                        <form action="{{ route('kasir.store') }}" method="POST">
                            @csrf

                            <select name="cabang_id" class="form-control mb-2" required>
                                @foreach($cabang as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>

                            <select name="menu_id" class="form-control mb-2">
                                @foreach($menu as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                                @endforeach
                            </select>

                            <input type="number" name="qty" class="form-control mb-2" value="1">

                            <button class="btn btn-danger w-100">
                                Proses Manual
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection