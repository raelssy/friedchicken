@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
    }

    /* Header Responsif */
    .header-wrapper {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .judul-halaman {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
        border-left: 5px solid #ffc107;
        padding-left: 15px;
        font-size: 1.25rem;
        margin-bottom: 0;
    }

    .btn-tambah {
        background-color: #e4002b;
        border: none;
        font-weight: 700;
        text-transform: uppercase;
        padding: 8px 16px;
        transition: all 0.3s;
        color: white;
        white-space: nowrap;
        font-size: 0.85rem;
    }

    .btn-cart {
        background-color: #28a745;
        color: white;
        font-weight: 700;
    }

    .btn-add-cart {
        background-color: #007bff;
        color: white;
        border-radius: 8px;
        font-size: 12px;
    }

    /* Card & Tabel */
    .card-tabel {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .thead-kuning {
        background-color: #ffc107 !important;
        color: #432C1E;
    }

    .thead-kuning th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 12px 10px;
    }

    /* Badge Custom */
    .badge-custom {
        font-size: 0.7rem;
        padding: 5px 10px;
        font-weight: 600;
    }

    .badge-makanan { background-color: #e4002b; color: white; }
    .badge-minuman { background-color: #ffc107; color: #432C1E; }
    
    .stok-aman { background-color: #28a745; color: white; }
    .stok-kritis { 
        background-color: #e4002b; 
        color: white; 
        animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .btn-edit { background-color: #ffc107; border: none; color: #432C1E; }
    .btn-hapus { background-color: #dc3545; border: none; color: white; }

    /* Responsive */
    @media (max-width: 576px) {
        .header-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-tambah {
            width: 100%;
            text-align: center;
        }
        .judul-halaman {
            font-size: 1.1rem;
        }
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
</style>

<div class="header-wrapper mb-4">

    <div class="d-flex align-items-center gap-3">

        <!-- BACK BUTTON -->
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm fw-bold">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- TITLE -->
        <h3 class="judul-halaman mb-0">Daftar Menu FnB</h3>

    </div>

    <div class="d-flex gap-2">

        <!-- 🛒 KERANJANG -->
        <a href="{{ route('cart') }}" class="btn btn-cart shadow-sm rounded-pill">
            <i class="fas fa-shopping-cart me-1"></i> Keranjang
        </a>

        <!-- TAMBAH MENU -->
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('menu.create') }}" class="btn btn-tambah shadow-sm rounded-pill">
            <i class="fa fa-plus-circle me-1"></i> Tambah Menu
        </a>
        @endif

    </div>

</div>

<div class="card card-tabel shadow-lg">
    <div class="card-body p-0">
        <div class="row">

                @forelse($menu as $m)
                <div class="col-md-4 col-sm-6 mb-4">

                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <!-- GAMBAR -->
                        <img src="{{ $m->gambar 
                            ? asset('storage/' . $m->gambar) 
                            : asset('images/default.png') }}"
                            style="width:100%; height:200px; object-fit:cover;">

                        <div class="card-body d-flex flex-column text-center p-3">

                            <!-- NAMA -->
                            <h5 class="fw-bold">{{ $m->nama_menu }}</h5>

                            <!-- KATEGORI -->
                            <span class="badge rounded-pill mb-2 badge-custom 
                                {{ $m->kategori == 'Makanan' ? 'badge-makanan' : 'badge-minuman' }}">
                                {{ $m->kategori }}
                            </span>

                            <!-- HARGA -->
                            <p class="fw-bold text-danger mb-1">
                                Rp{{ number_format($m->harga, 0, ',', '.') }}
                            </p>

                            <!-- STOK -->
                            @if($m->stok <= 5)
                                <span class="badge stok-kritis mb-2">
                                    Stok: {{ $m->stok }}
                                </span>
                            @else
                                <span class="badge stok-aman mb-2">
                                    Stok: {{ $m->stok }}
                                </span>
                            @endif

                            <!-- CART -->
                            <div class="mb-2">
                                @if($m->stok > 0)
                                    <a href="{{ route('cart.add', $m->id) }}" 
                                    class="btn btn-add-cart btn-sm w-100">
                                        <i class="fas fa-cart-plus"></i> Tambah
                                    </a>
                                @else
                                    <span class="text-muted">Stok Habis</span>
                                @endif
                            </div>

                            <!-- AKSI ADMIN -->
                            @if(auth()->user()->role == 'admin')
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('menu.edit', $m->id) }}" 
                                class="btn btn-edit btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('menu.destroy', $m->id) }}" 
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-hapus btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                            @endif

                        </div>
                    </div>

                </div>
                @empty
                <div class="text-center text-muted mt-5">
                    <i class="fas fa-cookie-bite fa-2x mb-3"></i>
                    <p>Belum ada menu</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

@endsection