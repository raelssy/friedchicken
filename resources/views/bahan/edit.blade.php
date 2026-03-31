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

    /* Header Styling - Kuning untuk fase Edit */
    .card-header-edit {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #432C1E;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem;
    }

    .card-header-edit h5 {
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
        color: #555;
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
        border-color: #e4002b;
        box-shadow: 0 0 0 0.2rem rgba(228, 0, 43, 0.1);
    }

    /* Button Styling */
    .btn-update-yellow {
        background-color: #ffc107;
        color: #432C1E;
        font-weight: 800;
        text-transform: uppercase;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-update-yellow:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    /* Responsive Mobile */
    @media (max-width: 576px) {
        .d-flex-mobile {
            flex-direction: column-reverse;
            gap: 10px;
        }
        .btn-update-yellow, .btn-light {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="form-edit-wrapper">
        
        <div class="mb-3">
            <a href="{{ route('stok.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Inventaris
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header card-header-edit border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-50 p-2 rounded-3 me-3">
                        <i class="fas fa-pencil-alt text-dark"></i>
                    </div>
                    <h5 class="mb-0">Edit Bahan Mentah</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('stok.bahan.update', $bahan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="label-custom text-danger">Nama Bahan</label>
                        <input type="text" name="nama_bahan" 
                               class="form-control form-control-custom fw-bold shadow-sm @error('nama_bahan') is-invalid @enderror" 
                               value="{{ old('nama_bahan', $bahan->nama_bahan) }}" required>
                        @error('nama_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="label-custom">Jumlah Stok</label>
                            <div class="input-group">
                                <input type="number" name="jumlah" 
                                       class="form-control form-control-custom shadow-sm @error('jumlah') is-invalid @enderror" 
                                       value="{{ old('jumlah', $bahan->jumlah) }}" min="0" required>
                            </div>
                            @error('jumlah')
                                <div class="text-danger mt-1" style="font-size: 10px;">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-6">
                            <label class="label-custom">Satuan</label>
                            <select name="satuan" class="form-select form-control-custom shadow-sm" required>
                                @foreach(['Kg', 'Gram', 'Liter', 'Pcs', 'Box'] as $satuan)
                                    <option value="{{ $satuan }}" {{ $bahan->satuan == $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2 d-flex-mobile">
                        <a href="{{ route('stok.index') }}" class="btn btn-light px-4 fw-bold text-muted border">Batal</a>
                        <button type="submit" class="btn btn-update-yellow shadow-sm">
                            <i class="fas fa-sync-alt me-1"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 p-3 bg-white rounded-3 shadow-sm border-start border-4 border-warning">
            <p class="small text-muted mb-0">
                <i class="fas fa-history me-1 text-warning"></i> 
                <strong>Log:</strong> Terakhir diupdate pada {{ $bahan->updated_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>
</div>
@endsection