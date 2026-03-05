@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-warning text-dark p-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Edit Bahan Mentah</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('stok.bahan.update', $bahan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label small fw-bold">Nama Bahan</label>
                            <input type="text" name="nama_bahan" 
                                   class="form-control form-control-sm @error('nama_bahan') is-invalid @enderror" 
                                   value="{{ old('nama_bahan', $bahan->nama_bahan) }}" required>
                            @error('nama_bahan')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold">Jumlah Stok</label>
                                <input type="number" name="jumlah" 
                                       class="form-control form-control-sm @error('jumlah') is-invalid @enderror" 
                                       value="{{ old('jumlah', $bahan->jumlah) }}" min="0" required>
                                @error('jumlah')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold">Satuan</label>
                                <select name="satuan" class="form-select form-select-sm" required>
                                    @foreach(['Kg', 'Gram', 'Liter', 'Pcs', 'Box'] as $satuan)
                                        <option value="{{ $satuan }}" {{ $bahan->satuan == $satuan ? 'selected' : '' }}>
                                            {{ $satuan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-sm px-4 shadow-sm text-dark fw-bold">
                                <i class="fas fa-save me-1"></i> Update Bahan
                            </button>
                            <a href="{{ route('stok.index') }}" class="btn btn-light btn-sm px-3 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection