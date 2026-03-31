@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .form-bahan-wrapper {
        max-width: 500px;
        margin: 0 auto;
    }

    /* Header Styling */
    .card-header-red {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem;
    }

    .card-header-red h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 1rem;
    }

    /* Input Styling */
    .label-custom {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #444;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        font-size: 14px !important;
        padding: 10px 12px !important;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-control-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    /* Button Styling */
    .btn-save-red {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-save-red:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.2);
    }

    .info-box-kuning {
        border-left: 4px solid #ffc107;
        background-color: white;
        padding: 15px;
        border-radius: 8px;
    }

    /* Responsive adjustment */
    @media (max-width: 576px) {
        .d-flex-mobile {
            flex-direction: column-reverse;
            gap: 10px;
        }
        .btn-save-red, .btn-light {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="form-bahan-wrapper">
        
        <nav class="mb-3">
            <a href="{{ route('stok.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-chevron-left me-1"></i> Kembali ke Inventaris
            </a>
        </nav>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header card-header-red border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-25 p-2 rounded-3 me-3">
                        <i class="fas fa-box-open text-warning"></i>
                    </div>
                    <h5 class="mb-0">Tambah Bahan Mentah</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('stok.bahan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="label-custom">Nama Bahan / Komoditas</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-tag"></i></span>
                            <input type="text" name="nama_bahan" 
                                   class="form-control form-control-custom border-start-0 ps-0 @error('nama_bahan') is-invalid @enderror" 
                                   placeholder="Misal: Tepung Terigu / Ayam Karkas" value="{{ old('nama_bahan') }}" required>
                        </div>
                        @error('nama_bahan')
                            <div class="text-danger mt-1" style="font-size: 10px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="label-custom">Jumlah Awal</label>
                            <input type="number" name="jumlah" 
                                   class="form-control form-control-custom shadow-sm @error('jumlah') is-invalid @enderror" 
                                   value="{{ old('jumlah', 0) }}" min="0" required>
                            @error('jumlah')
                                <div class="text-danger mt-1" style="font-size: 10px;">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-6">
                            <label class="label-custom">Satuan Ukur</label>
                            <select name="satuan" class="form-select form-control-custom shadow-sm" required>
                                <option value="Kg">Kilogram (Kg)</option>
                                <option value="Gram">Gram (gr)</option>
                                <option value="Liter">Liter (L)</option>
                                <option value="Pcs">Pcs / Butir</option>
                                <option value="Box">Box / Dus</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2 d-flex-mobile">
                        <a href="{{ route('stok.index') }}" class="btn btn-light px-4 fw-bold text-muted border">Batal</a>
                        <button type="submit" class="btn btn-save-red shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Bahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 info-box-kuning shadow-sm">
            <p class="small text-muted mb-0">
                <i class="fas fa-info-circle text-warning me-1"></i> 
                <strong>Catatan:</strong> Bahan mentah ini digunakan untuk melacak persediaan gudang pusat/dapur utama.
            </p>
        </div>
    </div>
</div>
@endsection