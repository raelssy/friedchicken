@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Menu FnB</h3>
        <a href="{{ route('menu.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa fa-plus"></i> Tambah Menu Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50px">No</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Stok</th>
                        <th width="180px" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($menu as $m)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $m->nama_menu }}</td>
                        <td>
                            <span class="badge {{ $m->kategori == 'Makanan' ? 'bg-info' : 'bg-success' }}">
                                {{ $m->kategori }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                        
                        <td class="text-center">
                            @if($m->stok <= 5)
                                <span class="badge bg-danger">Hampir Habis: {{ $m->stok }}</span>
                            @else
                                <span class="badge bg-secondary text-white">{{ $m->stok }}</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('menu.edit', $m->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="fa fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('menu.destroy', $m->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">Belum ada data menu tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection