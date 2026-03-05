@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Stok Bahan Mentah</h4>
        <a href="{{ route('stok.bahan.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Bahan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Nama Bahan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahan as $b)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $b->nama_bahan }}</td>
                        <td><span class="badge bg-info text-dark">{{ $b->jumlah }}</span></td>
                        <td>{{ $b->satuan }}</td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('stok.bahan.edit', $b->id) }}" class="btn btn-warning btn-sm text-white">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('stok.bahan.destroy', $b->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus bahan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data bahan baku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table thead th {
        font-weight: 600;
        font-size: 14px;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection