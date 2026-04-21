@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background: #f4f6f9;
        font-family: 'Montserrat', sans-serif;
    }

    /* HEADER */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .title {
        font-weight: 800;
        font-size: 20px;
    }

    .subtitle {
        font-size: 12px;
        color: #888;
    }

    /* SUMMARY */
    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .summary-title {
        font-size: 11px;
        color: #888;
        font-weight: 700;
    }

    .summary-value {
        font-size: 20px;
        font-weight: 800;
    }

    /* TABLE */
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .table thead {
        background: #fafafa;
    }

    .table th {
        font-size: 11px;
        text-transform: uppercase;
        color: #999;
    }

    .table tbody tr {
        transition: 0.2s;
    }

    .table tbody tr:hover {
        background: #fff5f6;
    }

    /* TEXT */
    .menu-name {
        font-weight: 700;
        font-size: 14px;
    }

    .menu-id {
        font-size: 11px;
        color: #aaa;
    }

    /* BADGE */
    .badge-qty {
        background: #fff3cd;
        color: #856404;
        font-weight: 700;
        border-radius: 20px;
        padding: 5px 10px;
    }

    /* TOTAL */
    .total {
        font-weight: 800;
        color: #e4002b;
    }

    /* BUTTON */
    .btn-kfc {
        background: #e4002b;
        color: white;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-back {
        border-radius: 8px;
    }
</style>

<div class="container py-4">

    <!-- HEADER -->
    <div class="header">

        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div>
                <div class="title">Riwayat Transaksi</div>
                <div class="subtitle">Semua transaksi hari ini</div>
            </div>
        </div>

        <a href="{{ route('kasir.create') }}" class="btn btn-kfc">
            + Transaksi
        </a>
    </div>

    <!-- SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="summary-card">
                <div class="summary-title">TOTAL OMSET</div>
                <div class="summary-value text-danger">
                    Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="summary-card">
                <div class="summary-title">ITEM TERJUAL</div>
                <div class="summary-value">
                    {{ $transaksi->sum('qty') }} Produk
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-container">
        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>no</th>
                    <th>Waktu</th>
                    <th>Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transaksi as $t)
                <tr>

                    <td class="fw-bold text-muted">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        <div>{{ $t->created_at->format('d M Y') }}</div>
                        <small class="text-muted">
                            {{ $t->created_at->format('H:i') }}
                        </small>
                    </td>

                    <td>
                        <div class="menu-name">
                            {{ $t->menu->nama_menu ?? 'Menu Terhapus' }}
                        </div>
                        <div class="menu-id">
                            #TX-{{ $t->id }}
                        </div>
                    </td>

                    <td class="text-center">
                        <span class="badge-qty">{{ $t->qty }}</span>
                    </td>

                    <td class="text-end total">
                        Rp {{ number_format($t->total, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        <a href="/kasir/edit/{{ $t->id }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Belum ada transaksi hari ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection