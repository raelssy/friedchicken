@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">POS / Kasir</h3>
        <a href="{{ route('kasir.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Transaksi Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Tanggal</th>
                        <th>Menu</th> <th class="text-center">Jumlah Item</th> 
                        <th>Total Bayar</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi as $t)
                    <tr>
                        <td class="ps-3">{{ $loop->iteration }}</td>
                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="fw-bold">{{ $t->menu->nama_menu ?? 'Menu Terhapus' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">
                                {{ $t->qty }} Item
                            </span>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($t->total) }}</td>
                        <td class="text-end pe-3">
                            <a href="/kasir/edit/{{ $t->id }}" class="btn btn-warning btn-sm text-white">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection