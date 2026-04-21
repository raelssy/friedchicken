@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .form-wrapper {
        max-width: 550px;
        margin: auto;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #e4002b, #b30022);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
    }

    .label-custom {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
    }

    .btn-save {
        background: #e4002b;
        color: white;
        font-weight: 700;
        border-radius: 8px;
    }

    .btn-save:hover {
        background: #b30022;
    }
</style>

<div class="container py-5">
<div class="form-wrapper">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- BACK -->
        <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        <!-- BATAL -->
        <a href="{{ route('stok.index') }}" class="btn btn-outline-danger">
            <i class="fas fa-times me-1"></i> Batal
        </a>

    </div>

    <!-- CARD -->
    <div class="card shadow border-0">

        <div class="card-header card-header-custom text-center">
            <h5 class="mb-0">
                <i class="fas fa-boxes me-2"></i>Tambah Stok Bahan
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('stok.store') }}" method="POST">
                @csrf

                <!-- CABANG -->
                <div class="mb-3">
                    <label class="label-custom">Cabang</label>
                    <select name="cabang_id" class="form-control" required>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="label-custom">Nama Bahan</label>
                    <input type="text" name="nama_bahan" class="form-control" required>
                </div>

                <!-- JUMLAH -->
                <div class="mb-3">
                    <label class="label-custom">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>

                <!-- SATUAN -->
                <div class="mb-3">
                    <label class="label-custom">Satuan</label>
                    <input type="text" name="satuan" class="form-control" required>
                </div>

                <hr>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">

                    <!-- BATAL -->
                    <a href="{{ route('stok.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>

                    <!-- SIMPAN -->
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
</div>

@endsection