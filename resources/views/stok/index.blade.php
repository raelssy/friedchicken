@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .judul-inventaris {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
        border-left: 5px solid #ffc107;
        padding-left: 15px;
    }

    /* Nav Tabs Styling */
    .nav-pills-custom .nav-link {
        color: #6c757d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 12px 20px;
        border-radius: 10px;
        transition: all 0.3s;
        border: 1px solid #dee2e6;
        background: white;
        margin-right: 10px;
    }

    .nav-pills-custom .nav-link.active {
        background-color: #e4002b !important;
        color: white !important;
        border-color: #e4002b;
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.2);
    }

    .nav-pills-custom .nav-link:hover:not(.active) {
        background-color: #fff3cd;
        color: #856404;
        border-color: #ffeeba;
    }

    /* Table Styling */
    .card-inventaris {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    .thead-custom {
        background-color: #ffc107;
        color: #432C1E;
    }

    .thead-custom th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 15px;
        border: none;
    }

    .badge-stok {
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 6px;
    }

    /* Action Buttons */
    .btn-action-custom {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }
        .nav-pills-custom {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        .nav-pills-custom .nav-link {
            white-space: nowrap;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 header-section">
        <div>
            <h3 class="judul-inventaris mb-0">Manajemen Inventaris</h3>
            <p class="text-muted small mb-0">Pantau ketersediaan stok menu dan bahan baku.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-pills nav-pills-custom mb-4" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active shadow-sm" id="pills-menu-tab" data-bs-toggle="pill" data-bs-target="#pills-menu" type="button" role="tab">
                <i class="fas fa-utensils me-2 text-warning"></i>Stok Menu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link shadow-sm" id="pills-bahan-tab" data-bs-toggle="pill" data-bs-target="#pills-bahan" type="button" role="tab">
                <i class="fas fa-box-open me-2 text-warning"></i>Stok Bahan
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <div class="tab-pane fade show active" id="pills-menu" role="tabpanel">
            <div class="card card-inventaris shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="ps-4">Nama Menu</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Sisa Stok</th>
                                    <th class="text-end pe-4">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menu as $m)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $m->nama_menu }}</td>
                                    <td><span class="badge bg-light text-danger border border-danger-subtle">{{ $m->kategori }}</span></td>
                                    <td class="text-center">
                                        @if($m->stok <= 5)
                                            <span class="badge bg-danger badge-stok shadow-sm">
                                                <i class="fas fa-exclamation-triangle me-1"></i> {{ $m->stok }}
                                            </span>
                                        @else
                                            <span class="badge bg-dark badge-stok shadow-sm text-warning">{{ $m->stok }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-warning btn-sm btn-action-custom text-dark shadow-sm">
                                            <i class="fas fa-plus-circle me-1"></i> Stok
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-bahan" role="tabpanel">
            <div class="card card-inventaris shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-stream me-2 text-danger"></i>Inventory Bahan</h6>
                    <a href="{{ route('stok.bahan.create') }}" class="btn btn-danger btn-sm btn-action-custom shadow-sm px-3">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="ps-4">Nama Bahan</th>
                                    <th>Jumlah Stok</th>
                                    <th>Satuan</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahan as $b)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $b->nama_bahan }}</td>
                                    <td><span class="badge bg-white text-dark border badge-stok shadow-sm">{{ $b->jumlah }}</span></td>
                                    <td><span class="text-muted fw-bold">{{ $b->satuan }}</span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('stok.bahan.edit', $b->id) }}" class="btn btn-outline-warning btn-sm border-0">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('stok.bahan.destroy', $b->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm border-0" onclick="return confirm('Hapus bahan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 opacity-25 text-danger"></i>
                                        <p class="mb-0">Belum ada data bahan mentah.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection