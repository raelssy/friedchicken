@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Inventaris</h4>
            <p class="text-muted small">Kelola stok produk siap jual dan bahan baku mentah</p>
        </div>
        </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-tabs border-0 mb-3" id="stokTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 border-0" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu-panel" type="button" role="tab">
                <i class="fas fa-utensils me-2"></i>Stok Menu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 border-0" id="bahan-tab" data-bs-toggle="tab" data-bs-target="#bahan-panel" type="button" role="tab">
                <i class="fas fa-box me-2"></i>Stok Bahan Mentah
            </button>
        </li>
    </ul>

    <div class="tab-content pt-2" id="stokTabContent">
        
        <div class="tab-pane fade show active" id="menu-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-3 small uppercase">Nama Menu</th>
                                    <th class="py-3 small uppercase">Kategori</th>
                                    <th class="py-3 small uppercase text-center">Tersedia</th>
                                    <th class="py-3 small uppercase text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menu as $m)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $m->nama_menu }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $m->kategori }}</span></td>
                                    <td class="text-center">
                                        @if($m->stok <= 5)
                                            <span class="badge bg-danger">Hampir Habis: {{ $m->stok }}</span>
                                        @else
                                            <span class="badge bg-primary px-3">{{ $m->stok }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit Stok
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

        <div class="tab-pane fade" id="bahan-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-success">Daftar Bahan Baku</h6>
                    <a href="{{ route('stok.bahan.create') }}" class="btn btn-success btn-sm px-3 shadow-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Bahan
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-3 small uppercase">Nama Bahan</th>
                                    <th class="py-3 small uppercase">Jumlah</th>
                                    <th class="py-3 small uppercase">Satuan</th>
                                    <th class="py-3 small uppercase text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahan as $b)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $b->nama_bahan }}</td>
                                    <td><span class="fw-bold text-success">{{ $b->jumlah }}</span></td>
                                    <td><span class="text-muted small">{{ $b->satuan }}</span></td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('stok.bahan.edit', $b->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('stok.bahan.destroy', $b->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus bahan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted small">
                                        Belum ada data bahan mentah. <br>
                                        <a href="{{ route('stok.bahan.create') }}" class="text-success text-decoration-none">Klik di sini untuk menambah.</a>
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

<style>
    /* Styling agar tab terlihat lebih modern */
    .nav-tabs .nav-link {
        color: #6c757d;
        background: none;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd !important;
        background: none;
    }
    #stokTab .nav-link#bahan-tab.active {
        color: #198754;
        border-bottom: 3px solid #198754 !important;
    }
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6c757d;
    }
</style>
@endsection