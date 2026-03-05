@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Data Cabang</h3>
            <p class="text-muted small">Daftar lokasi outlet FnB Anda</p>
        </div>
        <a href="/cabang/create" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Tambah Cabang
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" width="80px">No</th>
                            <th class="py-3">Nama Cabang</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">Telepon</th>
                            <th class="py-3 text-center" width="220px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cabang as $index => $c)
                        <tr>
                            <td class="px-4 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold text-dark">{{ $c->nama_cabang }}</td>
                            <td class="text-muted">{{ $c->alamat }}</td>
                            <td>{{ $c->telepon }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/cabang/{{ $c->id }}/edit" class="btn btn-warning btn-sm text-white px-3 shadow-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="/cabang/{{ $c->id }}" method="POST" onsubmit="return confirm('Yakin hapus cabang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data cabang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection