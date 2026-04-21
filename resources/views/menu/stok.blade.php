@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4>Tambah Stok Menu</h4>

    <div class="card p-4">
        <form action="{{ route('menu.stok.update', $menu->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Menu</label>
                <input type="text" class="form-control" value="{{ $menu->nama_menu }}" readonly>
            </div>

            <div class="mb-3">
                <label>Stok Saat Ini</label>
                <input type="text" class="form-control" value="{{ $menu->stok }}" readonly>
            </div>

            <div class="mb-3">
                <label>Tambah Stok</label>
                <input type="number" name="stok" class="form-control" min="1" step="0.01" required>

                @error('stok')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-success">Tambah</button>
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</div>
@endsection