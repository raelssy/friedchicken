@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('menu.index') }}" class="btn btn-link text-decoration-none text-muted mb-3 p-0">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Menu
            </a>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="fw-bold text-dark mb-0">Tambah Menu Baru</h4>
                    <p class="text-muted small mb-0">Silakan isi detail menu makanan atau minuman Anda.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_menu" class="form-label fw-semibold">Nama Menu</label>
                            <input type="text" 
                                   name="nama_menu" 
                                   id="nama_menu" 
                                   class="form-control @error('nama_menu') is-invalid @enderror" 
                                   placeholder="Contoh: Nasi Goreng Spesial" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" 
                                       name="harga" 
                                       id="harga" 
                                       class="form-control border-start-0" 
                                       placeholder="0" 
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="kategori" class="form-label fw-semibold">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Paket">Paket </option>
                                <option value="Snack">Snack</option>
                            </select>
                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('menu.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection