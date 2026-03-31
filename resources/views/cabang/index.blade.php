@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    /* Header Styling */
    .judul-cabang {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
        border-left: 5px solid #ffc107;
        padding-left: 15px;
    }

    .btn-tambah-cabang {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        border: none;
        transition: all 0.3s;
    }

    .btn-tambah-cabang:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.2);
    }

    /* Tabel Styling */
    .card-tabel-cabang {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    .thead-kuning-cabang {
        background-color: #ffc107 !important;
        color: #432C1E;
    }

    .thead-kuning-cabang th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px 10px;
        border: none;
    }

    /* Action Buttons */
    .btn-edit-kuning {
        background-color: #ffc107;
        color: #432C1E;
        font-weight: 700;
        border: none;
        font-size: 0.8rem;
    }

    .btn-edit-kuning:hover {
        background-color: #e0a800;
        color: #000;
    }

    .btn-hapus-merah {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        border: none;
        font-size: 0.8rem;
    }

    /* Responsive adjustment for mobile */
    @media (max-width: 576px) {
        .header-cabang {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }
        .btn-tambah-cabang {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 header-cabang">
        <div>
            <h3 class="judul-cabang mb-0">Data Cabang</h3>
            <p class="text-muted small mb-0">Kelola lokasi outlet FnB Anda</p>
        </div>
        <a href="/cabang/create" class="btn btn-tambah-cabang px-4 py-2 shadow-sm rounded-pill">
            <i class="fas fa-plus-circle me-1"></i> Tambah Cabang
        </a>
    </div>

    <div class="card card-tabel-cabang shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-kuning-cabang text-nowrap">
                        <tr>
                            <th class="px-4 text-center" width="60px">No</th>
                            <th>Nama Cabang</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th class="text-center" width="200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-nowrap">
                        @forelse($cabang as $index => $c)
                        <tr>
                            <td class="px-4 text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold text-dark"><i class="fas fa-store me-2 text-danger"></i>{{ $c->nama_cabang }}</span>
                            </td>
                            <td class="text-muted">
                                <small>{{ Str::limit($c->alamat, 40) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <i class="fas fa-phone-alt me-1 text-danger small"></i> {{ $c->telepon }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm rounded">
                                    <a href="/cabang/{{ $c->id }}/edit" class="btn btn-edit-kuning btn-sm px-3">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>

                                    <form action="/cabang/{{ $c->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus cabang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-hapus-merah btn-sm px-3">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-map-marked-alt fa-3x mb-3 opacity-25"></i>
                                <p class="fw-bold">Belum ada data cabang terdaftar.</p>
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