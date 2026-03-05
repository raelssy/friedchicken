@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-success text-white p-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Bahan Mentah</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('stok.bahan.store') }}" method="POST">
                        @csrf

                        <div class="mb-2">
                            <label class="form-label small fw-bold">Nama Bahan</label>
                            <input type="text" name="nama_bahan" 
                                   class="form-control form-control-sm @error('nama_bahan') is-invalid @enderror" 
                                   placeholder="Contoh: Ayam Mentah / Tepung" value="{{ old('nama_bahan') }}" required>
                            @error('nama_bahan')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold">Jumlah Awal</label>
                                <input type="number" name="jumlah" 
                                       class="form-control form-control-sm @error('jumlah') is-invalid @enderror" 
                                       value="{{ old('jumlah', 0) }}" min="0" required>
                                @error('jumlah')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold">Satuan</label>
                                <select name="satuan" class="form-select form-select-sm" required>
                                    <option value="Kg">Kilogram (Kg)</option>
                                    <option value="Gram">Gram (gr)</option>
                                    <option value="Liter">Liter (L)</option>
                                    <option value="Pcs">Pcs / Butir</option>
                                    <option value="Box">Box / Dus</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Simpan Bahan
                            </button>
                            <a href="{{ route('stok.index') }}" class="btn btn-light btn-sm px-3 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-3 p-2 bg-light rounded-3 border">
                <p class="small text-muted mb-0">
                    <i class="fas fa-info-circle text-success me-1"></i> 
                    <strong>Info:</strong> Bahan mentah ini digunakan untuk memantau stok gudang, bukan untuk menu yang dijual langsung.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection