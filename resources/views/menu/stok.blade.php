@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .form-edit-wrapper {
        max-width: 500px;
        margin: 0 auto;
    }

    /* HEADER (BEDA WARNA: MERAH = TAMBAH STOK) */
    .card-header-stok {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem;
    }

    .card-header-stok h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 1rem;
    }

    /* INPUT */
    .label-custom {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        font-size: 14px;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-control-custom:focus {
        border-color: #e4002b;
        box-shadow: 0 0 0 0.2rem rgba(228, 0, 43, 0.1);
    }

    /* BUTTON */
    .btn-submit {
        background-color: #e4002b;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
    }

    .btn-submit:hover {
        background-color: #b30022;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.3);
    }

    @media (max-width: 576px) {
        .d-flex-mobile {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn-submit, .btn-light {
            width: 100%;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="form-edit-wrapper">

        <!-- BACK -->
        <div class="mb-3">
            <a href="{{ route('stok.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Inventaris
            </a>
        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            <div class="card-header card-header-stok border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 p-2 rounded-3 me-3">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <h5 class="mb-0">Tambah Stok Menu</h5>
                </div>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('menu.stok.update', $menu->id) }}" method="POST">
                    @csrf

                    <!-- NAMA MENU -->
                    <div class="mb-3">
                        <label class="label-custom">Nama Menu</label>
                        <input type="text" 
                               class="form-control form-control-custom fw-bold shadow-sm" 
                               value="{{ $menu->nama_menu }}" readonly>
                    </div>

                    <!-- STOK SAAT INI -->
                    <div class="mb-3">
                        <label class="label-custom">Stok Saat Ini</label>
                        <input type="text" 
                               class="form-control form-control-custom shadow-sm" 
                               value="{{ $menu->stok }}" readonly>
                    </div>

                    <!-- TAMBAH STOK -->
                    <div class="mb-3">
                        <label class="label-custom text-danger">Tambah Stok</label>
                        <input type="number" name="stok"
                               class="form-control form-control-custom shadow-sm @error('stok') is-invalid @enderror"
                               min="1" required>

                        @error('stok')
                            <div class="text-danger mt-1" style="font-size: 11px;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-25">

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2 d-flex-mobile">

                        <a href="{{ route('stok.index') }}" class="btn btn-light px-4 fw-bold text-muted border">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-submit shadow-sm">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Stok
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection