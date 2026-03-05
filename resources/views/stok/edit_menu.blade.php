@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stok.index') }}">Manajemen Stok</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Stok Menu</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-utensils me-2"></i> Update Stok Menu
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Nama Menu</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 fw-bold" 
                                   value="{{ $menu->nama_menu }}" readonly>
                            <small class="text-muted">Nama menu tidak dapat diubah di sini.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Jumlah Stok (Porsi/Pcs)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-primary">
                                    <i class="fas fa-boxes text-primary"></i>
                                </span>
                                <input type="number" name="stok" 
                                       class="form-control form-control-lg border-primary shadow-sm @error('stok') is-invalid @enderror" 
                                       value="{{ old('stok', $menu->stok) }}" 
                                       min="0" 
                                       required 
                                       placeholder="Masukkan jumlah stok">
                            </div>
                            @error('stok')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> 
                                Angka ini akan muncul sebagai batas maksimal pembelian di halaman Kasir.
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 border-0 bg-light rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="fas fa-history me-2"></i>
                        <span>Terakhir diperbarui: {{ $menu->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection