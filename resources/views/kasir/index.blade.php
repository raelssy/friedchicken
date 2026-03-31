@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    /* Badge & Status */
    .badge-qty {
        background-color: #fff3cd;
        color: #856404;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid #ffeeba;
    }

    /* Table Styling */
    .table-container {
        border-radius: 15px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .table thead {
        background-color: #fdfdfd;
        border-bottom: 2px solid #eee;
    }

    .table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        padding: 15px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 14px;
        border-color: #f8f9fa;
    }

    /* KFC Red Button */
    .btn-kfc {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border: none;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .btn-kfc:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(228, 0, 43, 0.3);
        color: white;
    }

    /* Action Buttons */
    .btn-edit-small {
        color: #ffc107;
        background: none;
        border: none;
        padding: 5px 10px;
        transition: 0.2s;
    }

    .btn-edit-small:hover {
        color: #e0a800;
        transform: scale(1.2);
    }
</style>

<div class="container py-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-800 mb-1" style="letter-spacing: -1px; color: #222;">RIWAYAT TRANSAKSI</h3>
            <p class="text-muted small mb-0"><i class="fas fa-calendar-alt me-1"></i> Data penjualan real-time hari ini</p>
        </div>
        <a href="{{ route('kasir.create') }}" class="btn btn-kfc shadow-sm">
            <i class="fas fa-cart-plus me-2"></i> Transaksi Baru
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 shadow-sm border-start border-4 border-danger">
                <small class="text-muted fw-bold d-block mb-1">TOTAL OMSET</small>
                <h4 class="fw-800 mb-0">Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 shadow-sm border-start border-4 border-warning">
                <small class="text-muted fw-bold d-block mb-1">ITEM TERJUAL</small>
                <h4 class="fw-800 mb-0">{{ $transaksi->sum('qty') }} <span class="small fw-normal text-muted">Produk</span></h4>
            </div>
        </div>
    </div>

    <div class="table-container border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">ID</th>
                        <th width="15%">Waktu</th>
                        <th width="30%">Menu / Produk</th>
                        <th class="text-center" width="15%">Kuantitas</th>
                        <th class="text-end" width="20%">Total Bayar</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $t->created_at->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i>{{ $t->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3 text-danger d-none d-md-block">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $t->menu->nama_menu ?? 'Menu Terhapus' }}</span>
                                    <span class="text-muted small">ID: #TX-{{ $t->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-qty">
                                {{ $t->qty }}x
                            </span>
                        </td>
                        <td class="text-end fw-800 text-danger">
                            Rp {{ number_format($t->total, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <a href="/kasir/edit/{{ $t->id }}" class="btn-edit-small" title="Edit Transaksi">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Belum ada transaksi hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection