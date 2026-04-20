@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; /* Ukuran dasar yang nyaman di semua perangkat */
    }

    /* Membatasi lebar form agar tidak melar di laptop */
    .form-wrapper {
        max-width: 550px;
        margin: 0 auto;
    }

    /* Link Kembali */
    .btn-kembali {
        color: #6c757d;
        font-weight: 600;
        font-size: 13px;
        transition: color 0.3s;
    }
    .btn-kembali:hover {
        color: #e4002b;
    }

    /* Header Card Custom */
    .card-header-custom {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 18px;
    }

    .card-header-custom h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
        margin: 0;
    }

    /* Input Styling */
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

    .input-group-text-kuning {
        background-color: #ffc107;
        color: #432C1E;
        font-weight: 700;
        border: none;
        font-size: 13px;
    }

    /* Tombol Simpan */
    .btn-simpan {
        background-color: #e4002b;
        border: none;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        padding: 12px 20px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-simpan:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(228, 0, 43, 0.2);
    }

    .btn-batal {
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        color: #6c757d;
        text-decoration: none;
    }

    /* Penyesuaian layar HP */
    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        .card-body {
            padding: 20px !important;
        }
        .btn-simpan {
            width: 100%; /* Tombol jadi penuh di HP */
            margin-top: 10px;
        }
        .d-flex-mobile {
            flex-direction: column-reverse; /* Batal di bawah, Simpan di atas */
            gap: 10px;
        }
        .btn-batal {
            text-align: center;
            display: block;
        }
    }
</style>

<div class="container py-4 py-md-5">
    <div class="form-wrapper">
        
        <a href="{{ route('menu.index') }}" class="btn-kembali text-decoration-none mb-3 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>

        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header card-header-custom border-0">
                <h5><i class="fas fa-plus-circle me-2 text-warning"></i> Tambah Menu</h5>
                <p class="text-white-50 mb-0 mt-1" style="font-size: 11px;">Input produk baru ke dalam sistem FnB.</p>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('menu.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Cabang</label>
                        <select name="cabang_id" class="form-control" required>
                            <option value="">-- pilih cabang --</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">
                                    {{ $cabang->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_menu" class="label-custom">Nama Produk</label>
                        <input type="text" 
                               name="nama_menu" 
                               id="nama_menu" 
                               class="form-control form-control-custom @error('nama_menu') is-invalid @enderror" 
                               placeholder="Contoh: Paket Ayam Geprek" 
                               required>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-7 mb-3">
                            <label for="harga" class="label-custom">Harga Jual (Rp)</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text input-group-text-kuning">Rp</span>
                                <input type="number" 
                                       name="harga" 
                                       id="harga" 
                                       class="form-control form-control-custom border-start-0" 
                                       placeholder="0" 
                                       required>
                            </div>
                        </div>

                        <div class="col-sm-5 mb-3">
                            <label for="kategori" class="label-custom">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select form-control-custom shadow-sm" required>
                                <option value="" selected disabled>Pilih...</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Paket">Paket</option>
                                <option value="Snack">Snack</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="d-flex justify-content-between align-items-center d-flex-mobile">
                        <a href="{{ route('menu.index') }}" class="btn-batal">Batal</a>
                        
                        <button type="submit" class="btn btn-simpan rounded-3 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <p class="text-center text-muted mt-4 opacity-50" style="font-size: 10px;">
            <i class="fas fa-info-circle me-1"></i> Form ini mendukung sinkronisasi data instan.
        </p>
    </div>
</div>
@endsection