@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .dashboard-header {
        border-bottom: 4px solid #e4002b;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    .dashboard-title {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
    }

    .card-kfc {
        border-radius: 16px;
        color: white;
        padding: 25px;
    }

    .bg-merah-kfc { 
        background: linear-gradient(135deg, #e4002b, #b30022); 
    }

    .bg-hitam-kfc { 
        background: linear-gradient(135deg, #2b2b2b, #000); 
    }

    .stats-label {
        font-size: 0.75rem;
        font-weight: 700;
    }

    .stats-number {
        font-size: 1.8rem;
        font-weight: 800;
    }

    .judul-shortcut {
        font-weight: 800;
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
    }

    /* FLEX GRID */
    .shortcut-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .flex-item {
        width: 150px;
    }

    .shortcut-item {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #eee;
        min-height: 130px;
        transition: 0.25s;
    }

    .shortcut-item:hover {
        transform: translateY(-5px);
        border-color: #e4002b;
    }

    .lingkaran-ikon {
        width: 60px;
        height: 60px;
        background: #fff1f2;
        color: #e4002b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .label-shortcut {
        font-weight: 700;
        font-size: 13px;
        text-align: center;
    }
</style>

<!-- HEADER -->
<div class="dashboard-header d-flex justify-content-between">
    <div>
        <h2 class="dashboard-title">Manajer Toko</h2>
        <small class="text-muted">Pantau Penjualan & Stok Real-Time</small>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="text-danger fw-bold">
            <i class="far fa-calendar-alt"></i> {{ date('l, d M Y') }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- STATS -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card-kfc bg-merah-kfc">
            <div class="stats-label">Pendapatan Hari Ini</div>
            <div class="stats-number">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-kfc bg-hitam-kfc">
            <div class="stats-label">Total Transaksi</div>
            <div class="stats-number">{{ $totalTransaksi }} Pesanan</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-kfc bg-merah-kfc">
            <div class="stats-label">Porsi Terjual</div>
            <div class="stats-number">{{ $menuTerjual }} Produk</div>
        </div>
    </div>
</div>

<!-- JUDUL -->
<h5 class="judul-shortcut">Akses Cepat Layanan</h5>

<!-- FLEX MENU -->
<div class="shortcut-container">

    <a href="{{ route('kasir.create') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-cash-register"></i></div>
        <span class="label-shortcut">Transaksi Baru</span>
    </a>

    <a href="{{ route('kasir.index') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-history"></i></div>
        <span class="label-shortcut">Riwayat Kasir</span>
    </a>

    <a href="{{ url('/stok') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-boxes-stacked"></i></div>
        <span class="label-shortcut">Cek Stok</span>
    </a>

    @if(auth()->user()->role == 'admin')
    <a href="{{ route('resep.index') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-cogs"></i></div>
        <span class="label-shortcut">Kelola Resep</span>
    </a>
    @endif

    <a href="{{ url('/menu') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-utensils"></i></div>
        <span class="label-shortcut">Kelola Menu</span>
    </a>

    @if(auth()->user()->role == 'admin')

    <a href="{{ url('/cabang') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-store"></i></div>
        <span class="label-shortcut">Data Cabang</span>
    </a>

    <a href="{{ route('user.create') }}" class="shortcut-item flex-item">
        <div class="lingkaran-ikon"><i class="fas fa-user-plus"></i></div>
        <span class="label-shortcut">User Cabang</span>
    </a>

    @endif


</div>

@endsection