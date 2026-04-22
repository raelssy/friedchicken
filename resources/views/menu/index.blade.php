@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; /* Ukuran dasar standar */
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
        white-space: nowrap; /* Mencegah teks tombol pecah */
        font-size: 0.85rem;
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

    /* Media Query untuk HP */
    @media (max-width: 576px) {
        .header-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-tambah {
            width: 100%; /* Tombol lebar penuh di HP */
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

    <!-- BUTTON TAMBAH -->
    @if(auth()->user()->role == 'admin')
    <a href="{{ route('menu.create') }}" class="btn btn-tambah shadow-sm rounded-pill">
        <i class="fa fa-plus-circle me-1"></i> Tambah Menu
    </a>
    @endif

</div>

    <div class="card card-tabel shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-kuning text-nowrap">
                        <tr>
                            <th class="ps-4" width="60px">No</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th class="text-center">Stok</th>
                            @if(auth()->user()->role == 'admin')
                            <th width="150px" class="text-center pe-4">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="text-nowrap">
                        @forelse($menu as $m)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $m->nama_menu }}</span>
                            </td>
                            <td>
                                <span class="badge rounded-pill badge-custom {{ $m->kategori == 'Makanan' ? 'badge-makanan' : 'badge-minuman' }}">
                                    <i class="fas {{ $m->kategori == 'Makanan' ? 'fa-hamburger' : 'fa-glass-cheers' }} me-1"></i>
                                    {{ $m->kategori }}
                                </span>
                            </td>
                            <td class="fw-bold text-danger">
                                Rp{{ number_format($m->harga, 0, ',', '.') }}
                            </td>
                            
                            <td class="text-center">
                                @if($m->stok <= 5)
                                    <span class="badge stok-kritis rounded-pill badge-custom">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $m->stok }}
                                    </span>
                                @else
                                    <span class="badge stok-aman rounded-pill badge-custom">
                                        {{ $m->stok }}
                                    </span>
                                @endif
                            </td>
                            
                            @if(auth()->user()->role == 'admin')
                            <td class="text-center pe-4">
                                
                                <div class="btn-group" role="group">

                                    <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-edit btn-sm px-3">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('menu.destroy', $m->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-hapus btn-sm px-3">
                                            <i class="fa fa-trash"></i>
                                        </button>   
                                    </form>

                                </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-5">
                                <i class="fas fa-cookie-bite fa-2x mb-3 opacity-25"></i>
                                <p class="mb-0 small fw-bold">Belum ada data menu tersedia.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection