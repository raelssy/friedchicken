@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f4f4f4;
        font-family: 'Montserrat', sans-serif;
    }

    .card-form {
        max-width: 500px;
        margin: 40px auto;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        background: white;
    }

    .card-header {
        background: linear-gradient(135deg, #e4002b, #b30022);
        color: white;
        padding: 20px;
        font-weight: 800;
        font-size: 18px;
    }

    .card-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .btn-save {
        background: #e4002b;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 8px;
        width: 100%;
        font-weight: bold;
    }

    .btn-save:hover {
        background: #b30022;
    }
</style>

<div class="card-form">
    <div class="card-header">
        Tambah User Cabang
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('user.store') }}">
            @csrf

            <div class="form-group">
                <label>Nama User</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Pilih Cabang</label>
                <select name="cabang_id" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs as $c)
                        <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-save">
                Simpan User Cabang
            </button>

        </form>

    </div>
</div>
@endsection