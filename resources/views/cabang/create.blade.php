@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
    }

    /* Membatasi lebar form di layar laptop agar tidak melar */
    .form-wrapper {
        max-width: 550px;
        margin: 0 auto;
    }

    /* Header Styling */
    .card-header-red {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
    }

    .icon-box-kuning {
        background-color: rgba(255, 193, 7, 0.2);
        padding: 12px;
        border-radius: 10px;
        color: #ffc107;
    }

    /* Input & Label */
    .label-custom {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        color: #444;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        font-size: 14px !important;
        padding: 10px 12px !important;
        border-radius: 8px;
    }

    .form-control-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    .input-group-text-white {
        background-color: #fff;
        border-right: none;
        color: #e4002b;
    }

    /* Tombol */
    .btn-red-custom {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        padding: 10px 20px;
        border: none;
        transition: 0.3s;
    }

    .btn-red-custom:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-1px);
    }

    .border-info-custom {
        border-left: 4px solid #ffc107;
        background-color: #fff;
    }

    /* Responsive Mobile */
    @media (max-width: 576px) {
        .d-flex-mobile {
            flex-direction: column-reverse;
            gap: 10px;
        }
        .btn-red-custom, .btn-light {
            width: 100%;
            text-align: center;
        }
        .card-header-red h4 {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="form-wrapper">
        
        <nav class="mb-3">
            <a href="/cabang" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-chevron-left me-1"></i> Kembali ke Daftar Cabang
            </a>
        </nav>

        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header card-header-red border-0">
                <div class="d-flex align-items-center">
                    <div class="icon-box-kuning me-3">
                        <i class="fas fa-store-alt fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white">Tambah Cabang</h4>
                        <small class="text-white-50">Daftarkan outlet baru Anda</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="label-custom">Nama Cabang</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-white"><i class="fas fa-tag"></i></span>
                            <input type="text" name="nama_cabang" class="form-control form-control-custom border-start-0" 
                                   placeholder="Contoh: Surabaya Pusat" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="label-custom">Nomor Telepon</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-white"><i class="fas fa-phone"></i></span>
                            <input type="text" name="telepon" class="form-control form-control-custom border-start-0" 
                                   placeholder="0812xxxxxx">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="label-custom">Alamat Lengkap</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-white align-items-start pt-2"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea name="alamat" class="form-control form-control-custom border-start-0" 
                                      rows="3" placeholder="Masukkan alamat lengkap cabang..."></textarea>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-between align-items-center d-flex-mobile">
                        <a href="/cabang" class="btn btn-light px-4 fw-bold text-muted border">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-red-custom rounded-3 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Cabang
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4 p-3 border-info-custom rounded-3 shadow-sm">
            <small class="text-muted d-block">
                <i class="fas fa-info-circle me-1 text-danger"></i> 
                Pastikan data valid untuk memudahkan koordinasi operasional antar outlet.
            </small>
        </div>
    </div>
</div>
@endsection