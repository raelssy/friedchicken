@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body { background-color: #f8f9fa; font-family: 'Montserrat', sans-serif; }

    /* --- HEADER --- */
    .judul-halaman {
        color: #e4002b; font-weight: 800; text-transform: uppercase;
        border-left: 4px solid #ffc107; padding-left: 12px; font-size: 1.2rem;
    }
    .btn-tambah { background-color: #e4002b; border: none; color: white; font-weight: 700; }
    .btn-cart { background-color: #28a745; color: white; font-weight: 700; }

    /* --- RESPONSIVE GRID (HP: 2 Kolom, Desktop: 5 Kolom) --- */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        gap: 12px;
    }
    @media (min-width: 768px) { .menu-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 992px) { .menu-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (min-width: 1200px) { .menu-grid { grid-template-columns: repeat(5, 1fr); } }

    /* --- CARD COMPACT --- */
    .menu-card {
        border: none; border-radius: 15px; background: #fff;
        transition: transform 0.2s; overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .menu-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }

    .image-wrapper {
        position: relative; width: 100%; height: 130px; 
        background-color: #eee; overflow: hidden;
    }
    .image-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .badge-category {
        position: absolute; top: 8px; left: 8px; z-index: 5;
        font-size: 9px; font-weight: 800; padding: 3px 8px;
        border-radius: 50px; text-transform: uppercase;
    }

    .card-body-mini { padding: 10px; }
    .menu-title {
        font-size: 0.85rem; font-weight: 700; color: #333;
        margin-bottom: 4px; height: 34px; line-height: 1.2;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .price-tag { color: #e4002b; font-weight: 800; font-size: 0.95rem; margin-bottom: 6px; }

    .stock-badge {
        font-size: 9px; font-weight: 700; padding: 2px 6px;
        border-radius: 4px; border: 1px solid transparent;
    }
    .stock-low { background-color: #fff5f5; color: #e4002b; border-color: #feb2b2; }
    .stock-ok { background-color: #f0fff4; color: #2f855a; border-color: #9ae6b4; }

    .btn-mini {
        font-size: 10px; font-weight: 700; border-radius: 8px;
        padding: 8px 4px; text-transform: uppercase; border: none;
    }
    .btn-add { background-color: #007bff; color: white; width: 100%; }
    .btn-out { background-color: #f8f9fa; color: #adb5bd; width: 100%; cursor: not-allowed; }

    /* --- ADMIN TOOLS (FIX WARNA) --- */
    .admin-tools {
        display: flex; gap: 6px; margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f1f1;
    }
    .btn-tool {
        flex: 1; padding: 6px; font-size: 12px; border-radius: 6px;
        text-align: center; transition: 0.2s; border: none;
        display: flex; align-items: center; justify-content: center;
    }
    /* Kuning untuk Edit */
    .btn-edit-admin { background-color: #fff9db; color: #fab005; }
    .btn-edit-admin:hover { background-color: #fab005; color: white; }
    /* Merah untuk Hapus */
    .btn-delete-admin { background-color: #fff5f5; color: #fa5252; }
    .btn-delete-admin:hover { background-color: #fa5252; color: white; }
</style>

<div class="container py-4">
    
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-light rounded-circle shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h3 class="judul-halaman mb-0">Menu FnB</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('cart') }}" class="btn btn-cart btn-sm rounded-pill px-3 shadow-sm">
                <i class="fas fa-shopping-cart"></i>
            </a>
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('menu.create') }}" class="btn btn-tambah btn-sm rounded-pill px-3 shadow-sm">
                <i class="fa fa-plus"></i>
            </a>
            @endif
        </div>
    </div>

    <!-- GRID MENU -->
    <div class="menu-grid">
        @forelse($menu as $m)
        <div class="menu-card shadow-sm d-flex flex-column">
            
            <!-- GAMBAR & BADGE KATEGORI -->
            <div class="image-wrapper">
                @php
                    $catColor = 'bg-danger text-white';
                    if($m->kategori == 'Minuman') $catColor = 'bg-info text-white';
                    if($m->kategori == 'Snack') $catColor = 'bg-warning text-dark';
                    if($m->kategori == 'Paket') $catColor = 'bg-primary text-white';
                @endphp
                <span class="badge badge-category {{ $catColor }}">{{ $m->kategori }}</span>
                <img src="{{ $m->gambar ? asset('storage/' . $m->gambar) : asset('images/default.png') }}" 
                     onerror="this.src='https://placehold.co/300x200?text=Menu';" alt="img">
            </div>

            <!-- DETAIL KONTEN -->
            <div class="card-body-mini d-flex flex-column flex-grow-1">
                <h6 class="menu-title">{{ $m->nama_menu }}</h6>
                <div class="price-tag">Rp{{ number_format($m->harga, 0, ',', '.') }}</div>

                <div class="mb-2">
                    <span class="stock-badge {{ $m->stok <= 5 ? 'stock-low' : 'stock-ok' }}">
                        <i class="fas fa-box me-1"></i> Stok: {{ $m->stok }}
                    </span>
                </div>

                <!-- TOMBOL BELI -->
                <div class="mt-auto">
                    @if($m->stok > 0)
                        <a href="{{ route('cart.add', $m->id) }}" class="btn btn-mini btn-add shadow-sm">
                            <i class="fas fa-plus me-1"></i> Beli
                        </a>
                    @else
                        <button class="btn btn-mini btn-out shadow-sm" disabled>Habis</button>
                    @endif
                </div>

                <!-- ADMIN TOOLS (EDIT KUNING, HAPUS MERAH) -->
                @if(auth()->user()->role == 'admin')
                <div class="admin-tools">
                    <a href="{{ route('menu.edit', $m->id) }}" class="btn-tool btn-edit-admin shadow-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('menu.destroy', $m->id) }}" method="POST" style="flex:1">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn-tool btn-delete-admin shadow-sm w-100" onclick="return confirm('Hapus menu ini?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted small">Belum ada menu tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection