@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    background: #f8f9fa;
    font-family: 'Montserrat', sans-serif;
}

.form-wrapper {
    max-width: 650px;
    margin: auto;
}

.card-header-custom {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 18px;
}

.label {
    font-weight: 700;
    font-size: 12px;
    margin-bottom: 5px;
}

.form-control {
    border-radius: 8px;
}

.btn-add {
    background: #10b981;
    color: white;
}

.btn-remove {
    background: #ef4444;
    color: white;
}

.btn-save {
    background: #4f46e5;
    color: white;
    font-weight: bold;
}
</style>

<div class="container py-4">
<div class="form-wrapper">

<a href="{{ route('resep.index') }}" class="text-decoration-none mb-3 d-inline-block">
    ← Kembali
</a>

<div class="card shadow border-0 rounded-3">

    <div class="card-header-custom">
        <h5><i class="fas fa-utensils"></i> Tambah Resep</h5>
        <small>Atur bahan untuk setiap menu</small>
    </div>

    <div class="card-body">

        <form action="{{ route('resep.store') }}" method="POST">
            @csrf

            <!-- MENU -->
            <div class="mb-3">
                <label class="label">Menu</label>
                <select name="menu_id" class="form-control" required>
                    @foreach($menus as $m)
                        <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                    @endforeach
                </select>
            </div>

            <hr>

            <h6 class="mb-3">Bahan</h6>

            <div id="bahan-wrapper">

                <div class="row mb-2 bahan-item">
                    <div class="col-6">
                        <select name="bahan_id[]" class="form-control">
                            <option value="">Pilih bahan</option>
                            @foreach($bahans as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
                    </div>

                    <div class="col-2">
                        <button type="button" class="btn btn-remove w-100" onclick="hapusBahan(this)">
                            ✕
                        </button>
                    </div>
                </div>

            </div>

            <!-- BUTTON TAMBAH -->
            <button type="button" onclick="tambahBahan()" class="btn btn-add mt-2">
                + Tambah Bahan
            </button>

            <hr>

            <button class="btn btn-save mt-3 w-100">
                Simpan Resep
            </button>

        </form>

    </div>

</div>
</div>
</div>

<script>
function tambahBahan() {
    let wrapper = document.getElementById('bahan-wrapper');

    let html = `
    <div class="row mb-2 bahan-item">
        <div class="col-6">
            <select name="bahan_id[]" class="form-control">
                <option value="">Pilih bahan</option>
                @foreach($bahans as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-4">
            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
        </div>

        <div class="col-2">
            <button type="button" class="btn btn-remove w-100" onclick="hapusBahan(this)">
                ✕
            </button>
        </div>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

function hapusBahan(btn) {
    btn.closest('.bahan-item').remove();
}
</script>

@endsection