@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Edit Menu: {{ $menu->nama_menu }}</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control form-control-lg bg-light" value="{{ $menu->nama_menu }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control form-control-lg" value="{{ $menu->harga }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stok Siap Jual</label>
                                <input type="number" name="stok" class="form-control form-control-lg border-primary shadow-sm" value="{{ $menu->stok }}" min="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select form-select-lg">
                                <option value="Makanan" {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Minuman" {{ $menu->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="Paket" {{ $menu->kategori == 'Paket' ? 'selected' : '' }}>Paket Combo</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow">Update Menu & Stok</button>
                            <a href="{{ route('menu.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection