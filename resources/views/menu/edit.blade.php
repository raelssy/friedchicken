@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; /* Ukuran standar yang aman untuk HP & Laptop */
        color: #333;
    }

    /* Container Box - Membatasi lebar maksimal di laptop agar tidak melar */
    .form-container {
        max-width: 500px; /* Lebar ideal agar rapi di laptop */
        margin: 0 auto;
    }

    .card-custom {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    /* Header Card */
    .card-header-red {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        padding: 15px;
        text-align: center;
    }

    .card-header-red h5 {
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        text-transform: uppercase;
    }

    /* Label & Input */
    .label-sm {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 4px;
        display: block;
    }

    .form-control-sm-custom {
        font-size: 13px !important;
        padding: 8px 10px !important;
        border-radius: 6px;
    }

    .form-control-sm-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    /* Input Group untuk Harga */
    .input-group-text-kuning {
        background-color: #ffc107;
        color: #222;
        font-weight: 700;
        font-size: 12px;
        border: none;
    }

    /* Button */
    .btn-red-custom {
        background-color: #e4002b;
        color: white;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        padding: 10px;
        border: none;
        transition: 0.3s;
    }

    .btn-red-custom:hover {
        background-color: #b30022;
        color: white;
    }

    .btn-batal {
        font-size: 12px;
        color: #888;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<div class="container py-4">
    <div class="form-container">
        
        <div class="mb-3">
            <a href="{{ route('menu.index') }}" class="btn-batal">
                <i class="fas fa-arrow-left me-1"></i> Daftar Menu
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header card-header-red">
                <h5><i class="fas fa-edit me-2 text-warning"></i> Edit Menu</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="label-sm">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control form-control-sm-custom fw-bold" 
                               value="{{ $menu->nama_menu }}" required>
                    </div>

                    <div class="row g-2">
                        <div class="col-7 mb-3">
                            <label class="label-sm">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-kuning">Rp</span>
                                <input type="number" name="harga" class="form-control form-control-sm-custom" 
                                       value="{{ $menu->harga }}" required>
                            </div>
                        </div>

                        <div class="col-5 mb-3">
                            <label class="label-sm text-danger">Stok</label>
                            <input type="number" name="stok" class="form-control form-control-sm-custom border-warning fw-bold text-center" 
                                   value="{{ $menu->stok }}" min="0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="label-sm">Kategori Produk</label>
                        <select name="kategori" class="form-select form-select-sm form-control-sm-custom">
                            <option value="Makanan" {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ $menu->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Paket" {{ $menu->kategori == 'Paket' ? 'selected' : '' }}>Paket Combo</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-red-custom rounded-3 shadow-sm">
                            <i class="fas fa-save me-1"></i> Update Menu
                        </button>
                        <a href="{{ route('menu.index') }}" class="btn btn-light btn-sm fw-bold text-muted border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        
        <p class="text-center mt-3 text-muted" style="font-size: 10px;">
            Terakhir diubah: {{ $menu->updated_at->format('d/m/Y H:i') }}
        </p>
    </div>
</div>
@endsection