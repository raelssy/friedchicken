{{-- @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-success text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i> Edit Stok Bahan Mentah</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('stok.bahan.update', $bahan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Bahan Mentah</label>
                            <input type="text" name="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jumlah Stok</label>
                                <input type="number" name="jumlah" class="form-control form-control-lg border-success" 
                                       value="{{ $bahan->jumlah }}" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Satuan</label>
                                <select name="satuan" class="form-select form-select-lg">
                                    <option value="Kg" {{ $bahan->satuan == 'Kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
                                    <option value="Gram" {{ $bahan->satuan == 'Gram' ? 'selected' : '' }}>Gram (gr)</option>
                                    <option value="Liter" {{ $bahan->satuan == 'Liter' ? 'selected' : '' }}>Liter (L)</option>
                                    <option value="Pcs" {{ $bahan->satuan == 'Pcs' ? 'selected' : '' }}>Pcs/Butir</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg shadow">Update Stok Bahan</button>
                            <a href="{{ route('stok.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}