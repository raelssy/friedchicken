@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Montserrat', sans-serif;
    }

    /* --- HEADER POS --- */
    .card-header-kfc {
        background: linear-gradient(135deg, #e4002b, #b30022);
        color: white;
        padding: 20px;
        border-bottom: 5px solid #ffc107;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 20px 20px 0 0;
    }

    .btn-back-kfc {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 10px;
        padding: 5px 15px;
        transition: 0.3s;
    }

    .btn-back-kfc:hover {
        background: white;
        color: #e4002b;
    }

    /* --- GRID MENU --- */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        gap: 12px;
    }
    @media (min-width: 768px) { .menu-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1200px) { .menu-grid { grid-template-columns: repeat(4, 1fr); } }

    .menu-card {
        background: #fff;
        border-radius: 15px;
        padding: 10px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s;
        border: none;
    }

    .menu-card:hover:not(.out-of-stock) { transform: translateY(-5px); }

    /* Gaya visual untuk Menu Habis */
    .menu-card.out-of-stock {
        opacity: 0.7;
    }
    
    .menu-card.out-of-stock img {
        filter: grayscale(1);
    }

    .menu-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 8px;
    }

    /* --- QTY CONTROL --- */
    .qty-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .btn-qty {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid #e4002b;
        background: transparent;
        color: #e4002b;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-qty:hover {
        background: #e4002b;
        color: white;
    }

    /* --- CART SECTION --- */
    .cart-box {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .checkout-btn {
        background-color: #28a745;
        border: none;
        font-weight: 700;
        padding: 12px;
        border-radius: 12px;
        transition: 0.3s;
        color: white;
    }

    .checkout-btn:hover { background-color: #218838; }
</style>

<div class="container py-4">

    {{-- Hanya menampilkan Error Alert (Misal: Stok Habis) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-header card-header-kfc">
            <a href="{{ url('/dashboard') }}" class="btn-back-kfc text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <h4 class="mb-0 fw-bold">POS - KASIR</h4>
            <div style="width: 80px;"></div>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                
                <!-- LEFT: MENU LIST -->
                <div class="col-lg-7 border-end">
                    <h5 class="fw-bold mb-4"><i class="fas fa-utensils me-2 text-danger"></i> Daftar Menu</h5>
                    <div class="menu-grid">
                        @foreach($menu as $m)
                        <div class="menu-card {{ $m->stok <= 0 ? 'out-of-stock' : '' }}">
                            <img src="{{ $m->gambar ? asset('storage/'.$m->gambar) : 'https://via.placeholder.com/150' }}" alt="{{ $m->nama_menu }}">
                            <div class="small fw-bold text-truncate px-1">{{ $m->nama_menu }}</div>
                            <div class="text-danger fw-bold small">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                            
                            {{-- Indikator Stok --}}
                            <div class="small mb-2 {{ $m->stok <= 0 ? 'text-danger fw-bold' : 'text-muted' }}" style="font-size: 0.75rem;">
                                {{ $m->stok <= 0 ? 'STOK HABIS' : 'Stok: ' . $m->stok }}
                            </div>

                            @php
                                // Mencari item berdasarkan ID Menu untuk sinkronisasi
                                $itemInCart = $cart->where('menu_id', $m->id)->first();
                            @endphp

                            @if($m->stok <= 0)
                                <button class="btn btn-secondary btn-sm mt-2 w-100 rounded-pill fw-bold" disabled style="font-size: 0.75rem;">
                                    Tidak Tersedia
                                </button>
                            @else
                                @if($itemInCart)
                                    <div class="qty-control">
                                        {{-- Mengirim ID Menu ke Controller --}}
                                        <a href="{{ route('cart.decrease', $m->id) }}" class="btn-qty">
                                            <i class="fas fa-minus"></i>
                                        </a>
                                        <span class="fw-bold text-dark">{{ $itemInCart->qty }}</span>
                                        <a href="{{ route('cart.add', $m->id) }}" class="btn-qty">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('cart.add', $m->id) }}" class="btn btn-outline-danger btn-sm mt-2 w-100 rounded-pill fw-bold">
                                        <i class="fas fa-plus me-1"></i> Tambah
                                    </a>
                                @endif
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT: SHOPPING CART -->
                <div class="col-lg-5">
                    <div class="cart-box">
                        <h5 class="fw-bold mb-4"><i class="fas fa-shopping-cart me-2 text-success"></i> Keranjang Belanja</h5>

                        <div class="cart-items" style="max-height: 350px; overflow-y: auto;">
                            @php $total = 0; @endphp
                            @forelse($cart as $item)
                                @php 
                                    $subtotal = ($item->menu->harga ?? 0) * $item->qty;
                                    $total += $subtotal;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3 px-1">
                                    <div style="flex: 1;">
                                        <div class="fw-bold text-dark">{{ $item->menu->nama_menu ?? 'Menu Terhapus' }}</div>
                                        <small class="text-muted">{{ $item->qty }} x Rp {{ number_format($item->menu->harga ?? 0, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                        <a href="{{ route('cart.remove', $item->id) }}" class="text-muted small text-decoration-none">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-shopping-basket fa-3x text-light mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada item dipilih</p>
                                </div>
                            @endforelse
                        </div>

                        @if($cart->count() > 0)
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold text-dark mb-0">Total Tagihan</h5>
                                <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                            </div>

                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="fw-bold small mb-2 text-muted">Pilih Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-select border-0 bg-light py-2" required>
                                        <option value="">-- Pilih Pembayaran --</option>
                                        <option value="cash">💵 Cash (Tunai)</option>
                                        <option value="qris">📱 QRIS / Digital</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100 checkout-btn shadow-sm">
                                    <i class="fas fa-cash-register me-2"></i> SELESAIKAN PESANAN
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- INPUT MANUAL -->
                    <div class="mt-4 p-3 bg-white shadow-sm border border-light" style="border-radius: 15px;">
                         <h6 class="text-muted small fw-bold mb-3"><i class="fas fa-keyboard me-2"></i> INPUT MANUAL</h6>
                         <form action="{{ route('kasir.store') }}" method="POST">
                            @csrf
                            <div class="row g-2">
                                <div class="col-8">
                                    <select name="menu_id" class="form-select form-select-sm bg-light border-0">
                                        @foreach($menu as $m)
                                            <option value="{{ $m->id }}" {{ $m->stok <= 0 ? 'disabled' : '' }}>
                                                {{ $m->nama_menu }} {{ $m->stok <= 0 ? '(Habis)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="number" name="qty" class="form-control form-control-sm bg-light border-0" value="1" min="1">
                                </div>
                                <div class="col-2 text-end">
                                    <button class="btn btn-dark btn-sm w-100"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                         </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection