@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f4f4f4; 
        font-family: 'Montserrat', sans-serif;
        color: #333;
    }

    .dashboard-header {
        border-bottom: 4px solid #e4002b;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    .dashboard-title {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        margin: 0;
    }

    .card-kfc {
        border-radius: 15px;
        border: none;
        color: white;
        padding: 25px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card-kfc:hover {
        transform: translateY(-5px);
    }

    .bg-merah-kfc { background: linear-gradient(135deg, #e4002b 0%, #b30022 100%); }
    .bg-hitam-kfc { background: linear-gradient(135deg, #2b2b2b 0%, #000000 100%); }

    .stats-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        opacity: 0.9;
        letter-spacing: 1px;
    }

    .stats-number {
        font-size: 1.8rem;
        font-weight: 800;
        margin-top: 5px;
    }

    .judul-shortcut {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #202124;
        font-size: 1rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .judul-shortcut::before {
        content: "";
        width: 4px;
        height: 20px;
        background: #e4002b;
        margin-right: 10px;
        display: inline-block;
    }

    .shortcut-item {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid #eee;
        height: 100%;
    }

    .shortcut-item:hover {
        border-color: #e4002b;
        box-shadow: 0 10px 20px rgba(228, 0, 43, 0.1);
        transform: translateY(-5px);
    }

    .lingkaran-ikon {
        width: 65px;
        height: 65px;
        background-color: #fff1f2;
        color: #e4002b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .shortcut-item:hover .lingkaran-ikon {
        background-color: #e4002b;
        color: white;
    }

    .label-shortcut {
        font-weight: 700;
        color: #444;
        font-size: 0.85rem;
        text-align: center;
        line-height: 1.2;
    }
</style>

<div class="container-fluid px-4 pt-4">
    
    <div class="dashboard-header d-flex justify-content-between align-items-end">
        <div>
            <h2 class="dashboard-title">Manajer Toko</h2>
            <p class="text-muted small fw-bold mb-0">Pantau Penjualan & Stok Real-Time</p>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="fw-bold text-danger">
                <i class="far fa-calendar-alt me-1"></i> {{ date('l, d M Y') }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="
                    background:#e4002b;
                    color:white;
                    border:none;
                    padding:6px 12px;
                    border-radius:8px;
                    font-size:12px;
                    font-weight:600;
                    cursor:pointer;
                ">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="row mb-5 mt-2">
        <div class="col-md-4 mb-3">
            <div class="card-kfc bg-merah-kfc shadow-sm">
                <div class="stats-label">Pendapatan Hari Ini</div>
                <div class="stats-number">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card-kfc bg-hitam-kfc shadow-sm">
                <div class="stats-label">Total Transaksi</div>
                <div class="stats-number">{{ $totalTransaksi }} Pesanan</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card-kfc bg-merah-kfc shadow-sm">
                <div class="stats-label">Porsi Terjual</div>
                <div class="stats-number">{{ $menuTerjual }} Produk</div>
            </div>
        </div>
    </div>

    <h5 class="judul-shortcut">
    @if(auth()->user()->role == 'cabang')
        Pilih Mode Kerja
    @else
        Akses Cepat Layanan
    @endif
</h5>

{{-- ================= CABANG ================= --}}
@if(auth()->user()->role == 'cabang')

<div class="row g-4">

    <!-- MODE KASIR -->
    <div class="col-md-6">
        <a href="{{ route('kasir.create') }}" class="shortcut-item" style="height:130px;">
            <div class="lingkaran-ikon">
                <i class="fas fa-cash-register"></i>
            </div>
            <span class="label-shortcut">Mode Kasir</span>
            <small class="text-muted">Transaksi Penjualan</small>
        </a>
    </div>

    <!-- MODE STOK -->
    <div class="col-md-6">
        <a href="{{ url('/stok') }}" class="shortcut-item" style="height:130px;">
            <div class="lingkaran-ikon">
                <i class="fas fa-boxes"></i>
            </div>
            <span class="label-shortcut">Kelola Stok</span>
            <small class="text-muted">Update Stok Cabang</small>
        </a>
    </div>

</div>

{{-- ================= ADMIN ================= --}}
@else

<div class="row g-4">

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('kasir.create') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-cash-register"></i></div>
            <span class="label-shortcut">Transaksi Baru</span>
        </a>
    </div>

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('kasir.index') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-history"></i></div>
            <span class="label-shortcut">Riwayat Kasir</span>
        </a>
    </div>

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ url('/stok') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-boxes-stacked"></i></div>
            <span class="label-shortcut">Cek Stok</span>
        </a>
    </div>

    @if(auth()->user()->role == 'admin')
        <a href="{{ route('resep.index') }}" 
        class="btn btn-dark">
            ⚙️ Kelola Resep
        </a>
    @endif

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ url('/menu') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-utensils"></i></div>
            <span class="label-shortcut">Kelola Menu</span>
        </a>
    </div>

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ url('/cabang') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-store"></i></div>
            <span class="label-shortcut">Data Cabang</span>
        </a>
    </div>

    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('user.create') }}" class="shortcut-item">
            <div class="lingkaran-ikon"><i class="fas fa-user-plus"></i></div>
            <span class="label-shortcut">User Cabang</span>
        </a>
    </div>

</div>

@endif