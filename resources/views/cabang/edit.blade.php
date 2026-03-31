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

    /* Membatasi lebar agar tetap proporsional di laptop */
    .edit-form-wrapper {
        max-width: 500px;
        margin: 0 auto;
    }

    .btn-kembali-link {
        color: #6c757d;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-kembali-link:hover {
        color: #e4002b;
    }

    /* Header Card */
    .card-header-edit {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
        text-align: center;
    }

    .card-header-edit h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
        font-size: 1.1rem;
    }

    /* Input Styling */
    .label-edit {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }

    .form-control-edit {
        font-size: 14px !important;
        padding: 10px 15px !important;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-control-edit:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    /* Tombol Update */
    .btn-update-red {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        padding: 12px;
        border: none;
        border-radius: 8px;
        transition: 0.3s;
        font-size: 13px;
    }

    .btn-update-red:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(228, 0, 43, 0.3);
    }

    .btn-batal-edit {
        font-weight: 700;
        font-size: 12px;
        color: #888;
        text-decoration: none;
        text-transform: uppercase;
    }

    /* Media Query HP */
    @media (max-width: 576px) {
        .container {
            padding-left: 20px;
            padding-right: 20px;
        }
        .card-header-edit h5 {
            font-size: 1rem;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="edit-form-wrapper">
        
        <div class="mb-3">
            <a href="/cabang" class="btn-kembali-link text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Cabang
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header card-header-edit border-0">
                <h5><i class="fas fa-edit me-2 text-warning"></i> Edit Data Cabang</h5>
            </div>

            <div class="card-body p-4">
                <form action="/cabang/{{ $cabang->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="label-edit">Nama Cabang</label>
                        <input type="text" name="nama_cabang" class="form-control form-control-edit fw-bold shadow-sm" 
                               value="{{ $cabang->nama_cabang }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="label-edit">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-danger"><i class="fas fa-phone"></i></span>
                            <input type="text" name="telepon" class="form-control form-control-edit border-start-0 ps-0 shadow-sm" 
                                   value="{{ $cabang->telepon }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="label-edit">Alamat Cabang</label>
                        <textarea name="alamat" class="form-control form-control-edit shadow-sm" rows="3" required>{{ $cabang->alamat }}</textarea>
                    </div>

                    <hr class="opacity-25 my-4">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-update-red shadow">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <div class="text-center mt-2">
                            <a href="/cabang" class="btn-batal-edit">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <p class="text-center text-muted mt-4" style="font-size: 10px; opacity: 0.6;">
            ID Cabang: <span class="fw-bold">{{ $cabang->id }}</span> | Sinkronisasi Database Aktif
        </p>
    </div>
</div>
@endsection