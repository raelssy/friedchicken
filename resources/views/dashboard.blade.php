@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f8fafc;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .dashboard-title {
        color: #1e293b;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Card Styling */
    .card-custom {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-link {
        text-decoration: none;
        display: block;
    }

    .card-link:hover .card-custom {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Gradients */
    .bg-gradient-primary { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .bg-gradient-danger  { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

    .card-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.15;
        transform: rotate(-15deg);
    }

    .stats-label {
        font-size: 0.95rem;
        font-weight: 600;
        opacity: 0.85;
    }

    .stats-number {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .view-details-bar {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(4px);
        padding: 8px;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Quick Action Buttons */
    .btn-action {
        border-radius: 15px;
        padding: 15px 25px;
        font-weight: 600;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
    }

    .btn-action:hover {
        background: #f1f5f9;
        transform: scale(1.02);
        color: #1e293b;
    }
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="dashboard-title mb-1">Ringkasan Bisnis</h2>
           
        </div>
        <div class="text-muted fw-semibold">
            <i class="far fa-calendar-alt me-1"></i> {{ date('d M Y') }}
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('kasir.index') }}" class="card-link">
                <div class="card card-custom text-white bg-gradient-primary h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="stats-label mb-2 text-uppercase">Pendapatan Hari Ini</div>
                        <div class="stats-number">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                        <i class="fas fa-wallet card-icon"></i>
                    </div>
                    <div class="view-details-bar">Detail Penjualan <i class="fas fa-chevron-right ms-1"></i></div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('kasir.index') }}" class="card-link">
                <div class="card card-custom text-white bg-gradient-success h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="stats-label mb-2 text-uppercase">Pesanan Selesai</div>
                        <div class="stats-number">{{ $totalTransaksi }} <span style="font-size: 1rem; opacity: 0.8;">Transaksi</span></div>
                        <i class="fas fa-receipt card-icon"></i>
                    </div>
                    <div class="view-details-bar">Riwayat Transaksi <i class="fas fa-chevron-right ms-1"></i></div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/menu') }}" class="card-link">
                <div class="card card-custom text-white bg-gradient-warning h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="stats-label mb-2 text-uppercase">Porsi Terjual</div>
                        <div class="stats-number">{{ $menuTerjual }} <span style="font-size: 1rem; opacity: 0.8;">Item</span></div>
                        <i class="fas fa-drumstick-bite card-icon"></i>
                    </div>
                    <div class="view-details-bar">Cek Menu <i class="fas fa-chevron-right ms-1"></i></div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/menu') }}" class="card-link">
                <div class="card card-custom text-white bg-gradient-danger h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="stats-label mb-2 text-uppercase">Stok Menipis</div>
                        <div class="stats-number">{{ $stokMenipis }} <span style="font-size: 1rem; opacity: 0.8;">Perlu Restock</span></div>
                        <i class="fas fa-boxes card-icon"></i>
                    </div>
                    <div class="view-details-bar">Kelola Inventaris <i class="fas fa-chevron-right ms-1"></i></div>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-4">
        <h4 class="fw-bold mb-3 text-dark">Aksi Cepat</h4>
        <div class="row g-3">
            <div class="col-auto">
                <a href="{{ route('kasir.create') }}" class="btn btn-action shadow-sm d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-plus"></i>
                    </div>
                    Transaksi Baru
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ url('/menu') }}" class="btn btn-action shadow-sm d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-utensils"></i>
                    </div>
                    Update Menu
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ url('/cabang') }}" class="btn btn-action shadow-sm d-flex align-items-center">
                    <div class="bg-info text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-store"></i>
                    </div>
                    Data Cabang
                </a>
            </div>
        </div>
    </div>
</div>

@endsection