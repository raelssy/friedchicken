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

    .nav-pills-custom .nav-link {
        color: #6c757d;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        background: white;
        margin-right: 10px;
    }

    .nav-pills-custom .nav-link.active {
        background-color: #e4002b !important;
        color: white !important;
    }

    .card-inventaris {
        border-radius: 15px;
        overflow: hidden;
    }

    .thead-custom {
        background-color: #ffc107;
    }

    .thead-custom th {
        font-weight: 700;
        font-size: 0.75rem;
        padding: 15px;
    }

    .badge-stok {
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 6px;
    }

    .btn-action-custom {
        font-weight: 700;
        font-size: 0.75rem;
        border-radius: 8px;
    }
</style>

<div class="container mt-4 mb-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

    <div class="d-flex align-items-center gap-3">
        
        <!-- BACK BUTTON -->
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm fw-bold">
            <i class="fas fa-arrow-left me-1"></i> 
        </a>

        <!-- TITLE -->
        <div>
            <h3 class="judul-inventaris mb-0">Manajemen Inventaris</h3>
            <p class="text-muted small mb-0">
                Pantau ketersediaan stok menu dan bahan baku.
            </p>
        </div>

    </div>

</div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- TAB -->
    <ul class="nav nav-pills nav-pills-custom mb-4">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-menu">
                🍗 Stok Menu
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-bahan">
                📦 Stok Bahan
            </button>
        </li>
    </ul>

    <div class="tab-content">

        @if(auth()->user()->role == 'admin')

        <form method="GET" class="mb-3 d-flex gap-2">

            <select name="cabang_id" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Semua Cabang</option>

                @foreach($cabangs as $c)
                    <option value="{{ $c->id }}"
                        {{ request('cabang_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->nama_cabang }}
                    </option>
                @endforeach
            </select>

        </form>

        @endif

        <!-- ================= STOK MENU ================= -->
        <div class="tab-pane fade show active" id="pills-menu">

            <div class="card card-inventaris shadow-sm">

                <!-- HEADER CARD (FIX DI SINI) -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-utensils text-danger me-2"></i>
                        Inventory Menu
                    </h6>

                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('menu.create') }}" class="btn btn-danger btn-sm btn-action-custom">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    @endif

                </div>

                <!-- TABLE -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-custom">
                        <tr>
                            @if(auth()->user()->role == 'admin')
                            <th>Cabang</th>
                            @endif
                                <th class="ps-4">Nama Menu</th>
                                <th>Kategori</th>
                                <th class="text-center">Sisa Stok</th>
                                <th class="text-end pe-4">Opsi</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($menus as $m)
                            <tr>
                                @if(auth()->user()->role == 'admin')
                                <td>{{ $m->cabang->nama_cabang ?? '-' }}</td>
                                @endif
                                <td class="ps-4 fw-bold">{{ $m->nama_menu }}</td>

                                <td>
                                    <span class="badge bg-light text-danger border">
                                        {{ $m->kategori }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($m->stok <= 5)
                                        <span class="badge bg-danger badge-stok">
                                            ⚠ {{ $m->stok }}
                                        </span>
                                    @else
                                        <span class="badge bg-dark text-warning badge-stok">
                                            {{ $m->stok }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('menu.stok.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-plus-circle"></i> Stok
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

        <!-- ================= STOK BAHAN ================= -->
        <div class="tab-pane fade" id="pills-bahan">

            <div class="card card-inventaris shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-box text-warning me-2"></i>
                        Inventory Bahan
                    </h6>

                    <a href="{{ route('stok.bahan.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-custom">
                            <tr>
                                <th class="ps-4">Nama Bahan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($bahan as $b)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $b->nama_bahan }}</td>
                                <td>{{ $b->jumlah }}</td>
                                <td>{{ $b->satuan }}</td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('stok.bahan.edit', $b->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('stok.bahan.destroy', $b->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    Belum ada stok bahan
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