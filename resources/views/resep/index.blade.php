@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .judul {
        color: #e4002b;
        font-weight: 800;
        text-transform: uppercase;
        border-left: 5px solid #ffc107;
        padding-left: 15px;
    }

    .card-custom {
        border-radius: 15px;
        overflow: hidden;
        border: none;
    }

    .thead-custom {
        background: #ffc107;
    }

    .thead-custom th {
        font-weight: 700;
        font-size: 0.75rem;
        padding: 14px;
    }

    /* 🔥 BUTTON MERAH */
    .btn-merah {
        background: #e4002b;
        color: white;
        font-weight: 700;
        border-radius: 8px;
        border: none;
    }

    .btn-merah:hover {
        background: #b30022;
        color: white;
    }

    .btn-merah-sm {
        padding: 5px 12px;
        font-size: 13px;
    }
</style>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="d-flex align-items-center gap-3">
            
            <!-- BACK -->
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div>
                <h3 class="judul mb-0">Kelola Resep</h3>
                <small class="text-muted">Atur komposisi bahan setiap menu</small>
            </div>

        </div>

    </div>

    <!-- CARD -->
    <div class="card card-custom shadow-sm">

        <!-- HEADER CARD -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <span class="fw-bold">Daftar Resep</span>

            <!-- 🔥 TOMBOL MERAH -->
            <a href="{{ route('resep.create') }}" class="btn btn-merah btn-merah-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>

        </div>

        <!-- TABLE -->
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">

                <thead class="thead-custom">
                    <tr>
                        <th class="ps-4">Menu</th>
                        <th>Bahan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reseps as $menuId => $items)
                    <tr>

                        <!-- MENU -->
                        <td class="ps-4 fw-bold">
                            {{ $items->first()->menu->nama_menu }}
                        </td>

                        <!-- BAHAN -->
                        <td>
                            @foreach($items as $r)
                                @if(is_object($r) && $r->bahan)
                                    <div>• {{ $r->bahan->nama_bahan }} ({{ $r->jumlah }})</div>
                                @endif
                            @endforeach
                        </td>

                        <!-- AKSI -->
                        <td class="text-end pe-4">
                            @foreach($items as $r)
                                <form action="{{ route('resep.destroy', $r->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mb-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endforeach
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            Belum ada resep
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection