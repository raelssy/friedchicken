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
    max-width: 650px;
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
    margin-bottom: 5px;
}

.form-control {
    border-radius: 8px;
}

/* bahan box */
.bahan-item {
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #eee;
}

/* button */
.btn-save {
    background: #e4002b;
    color: white;
    font-weight: 700;
    border-radius: 8px;
}

.btn-save:hover {
    background: #b30022;
}

.btn-outline-danger {
    border-radius: 8px;
}

.radio-label {
    font-size: 12px;
    font-weight: 600;
}
</style>

<div class="container py-5">
<div class="form-wrapper">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- <a href="{{ route('resep.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> 
        </a> --}}

    </div>

    <!-- CARD -->
    <div class="card shadow border-0">

        <div class="card-header card-header-custom text-center">
            <h5 class="mb-0">
                <i class="fas fa-utensils me-2"></i>Tambah Resep
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('resep.store') }}" method="POST">
                @csrf

                <!-- MENU -->
                <div class="mb-3">
                    <label class="label-custom">Menu</label>
                    <select name="menu_id" class="form-control" required>
                        @foreach($menus as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <h6 class="mb-3 fw-bold">Bahan</h6>

                <div id="bahan-wrapper">

                    <div class="row mb-3 bahan-item align-items-center">

                        <div class="col-md-5">
                            <select name="bahan[0][bahan_id]" class="form-control">
                                <option value="">Pilih bahan</option>
                                @foreach($bahans as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="number" step="0.01" name="bahan[0][jumlah]" 
                                   class="form-control" placeholder="Jumlah">
                        </div>

                        <div class="col-md-2 text-center">
                            <label class="radio-label">
                                <input type="radio" name="main_bahan"> Utama
                            </label>
                        </div>

                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBahan(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                    </div>

                </div>

                <!-- TAMBAH -->
                <button type="button" onclick="tambahBahan()" class="btn btn-outline-danger w-100 mb-3">
                    <i class="fas fa-plus"></i> Tambah Bahan
                </button>

                <hr>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">

                    <a href="{{ route('resep.index') }}" class="btn btn-outline-danger">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
</div>

<script>
let index = 1;

function tambahBahan() {
    let wrapper = document.getElementById('bahan-wrapper');

    let html = `
    <div class="row mb-3 bahan-item align-items-center">

        <div class="col-md-5">
            <select name="bahan[${index}][bahan_id]" class="form-control">
                <option value="">Pilih bahan</option>
                @foreach($bahans as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="number" step="0.01" name="bahan[${index}][jumlah]" 
                   class="form-control" placeholder="Jumlah">
        </div>

        <div class="col-md-2 text-center">
            <label class="radio-label">
                <input type="radio" name="main_bahan"> Utama
            </label>
        </div>

        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBahan(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>

    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    index++;
}

function hapusBahan(btn) {
    btn.closest('.bahan-item').remove();
}
</script>

@endsection