@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <a href="/cabang" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Cabang
                </a>
            </nav>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-store-alt text-primary fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Tambah Cabang</h4>
                            <p class="text-muted small mb-0">Daftarkan lokasi outlet baru Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="/cabang/store" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Cabang</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-tag text-muted"></i>
                                </span>
                                <input type="text" name="nama_cabang" class="form-control border-start-0 ps-0" 
                                       placeholder="Contoh: Cabang Surabaya Pusat" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nomor Telepon</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" name="telepon" class="form-control border-start-0 ps-0" 
                                       placeholder="0812xxxxxx">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Alamat Lengkap</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 align-items-start pt-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                </span>
                                <textarea name="alamat" class="form-control border-start-0 ps-0" 
                                          rows="3" placeholder="Masukkan alamat lengkap cabang..."></textarea>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="/cabang" class="btn btn-light px-4 fw-semibold text-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">
                                <i class="fas fa-save me-1"></i> Simpan Cabang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-light rounded-3 border-start border-primary border-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1 text-primary"></i> 
                    Pastikan alamat dan nomor telepon valid agar memudahkan koordinasi antar cabang.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection