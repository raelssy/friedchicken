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

    /* Pembatas lebar form agar tidak melar di laptop */
    .stok-form-wrapper {
        max-width: 550px;
        margin: 0 auto;
    }

    /* Header Card Custom */
    .card-header-stok {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
    }

    .card-header-stok h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
        font-size: 1.1rem;
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

    .form-control-stok {
        font-size: 14px !important;
        padding: 10px 12px !important;
        border-radius: 8px;
    }

    .form-control-stok:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    .input-group-text-kuning {
        background-color: #ffc107;
        color: #432C1E;
        font-weight: 700;
        border: none;
        font-size: 13px;
    }

    /* Tombol Simpan */
    .btn-simpan-stok {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        padding: 12px 20px;
        border: none;
        transition: 0.3s;
        border-radius: 8px;
    }

    .btn-simpan-stok:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.2);
    }

    /* Link Kembali */
    .btn-kembali-stok {
        color: #6c757d;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-kembali-stok:hover { color: #e4002b; }

    /* Responsive Mobile */
    @media (max-width: 576px) {
        .btn-simpan-stok {
            width: 100%;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="stok-form-wrapper">
        
        <a href="{{ route('stok.index') }}" class="btn-kembali-stok text-decoration-none mb-3 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Stok
        </a>

        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header card-header-stok border-0 shadow-sm">
                <div class="d-flex align-items-center justify-content-center">
                    <h5><i class="fas fa-boxes me-2 text-warning"></i> Input Stok Bahan</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('stok.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="label-custom">Lokasi Cabang</label>
                        <select name="cabang_id" class="form-select form-control-stok shadow-sm" required>
                            <option value="" selected disabled>-- Pilih Cabang --</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">
                                    {{ $cabang->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="label-custom">Nama Bahan / Inventaris</label>
                        <input type="text" name="nama_bahan" class="form-control form-control-stok shadow-sm" 
                               placeholder="Misal: Daging Ayam Fillet" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-7 mb-3">
                            <label class="label-custom">Jumlah Masuk</label>
                            <input type="number" name="jumlah" class="form-control form-control-stok shadow-sm" 
                                   placeholder="0" required>
                        </div>

                        <div class="col-5 mb-3">
                            <label class="label-custom">Satuan</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text input-group-text-kuning small"><i class="fas fa-balance-scale"></i></span>
                                <input type="text" name="satuan" class="form-control form-control-stok border-start-0" 
                                       placeholder="Kg/Pcs" required>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-simpan-stok shadow">
                            <i class="fas fa-save me-2"></i> Simpan Stok Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <small class="text-muted opacity-50">
                <i class="fas fa-warehouse me-1"></i> Stok yang diinput akan otomatis menambah total inventaris cabang.
            </small>
        </div>
    </div>
</div>
@endsection