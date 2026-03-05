@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="/cabang" class="btn btn-link text-decoration-none text-muted mb-3 p-0">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 text-center">
                    <h4 class="fw-bold text-dark mb-0">Edit Data Cabang</h4>
                </div>

                <div class="card-body p-4">
                    <form action="/cabang/{{ $cabang->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Cabang</label>
                            <input type="text" name="nama_cabang" class="form-control form-control-lg shadow-sm" 
                                   value="{{ $cabang->nama_cabang }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Telepon</label>
                            <input type="text" name="telepon" class="form-control form-control-lg shadow-sm" 
                                   value="{{ $cabang->telepon }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Alamat</label>
                            <textarea name="alamat" class="form-control shadow-sm" rows="3">{{ $cabang->alamat }}</textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow fw-bold">
                                <i class="fas fa-save me-1"></i> Update Cabang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection