@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Kelola Resep</h3>

    <a href="{{ route('resep.create') }}" class="btn btn-primary mb-3">
        + Tambah Resep
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Bahan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reseps as $menuId => $items)
            <tr>
                <!-- MENU -->
                <td>
                    {{ $items->first()->menu->nama_menu }}
                </td>

                <!-- BAHAN -->
                <td>
                    @foreach($items as $r)

                        @if(is_object($r) && $r->bahan)
                            • {{ $r->bahan->nama_bahan }} ({{ $r->jumlah }}) <br>
                        @endif

                    @endforeach
                </td>

                <!-- TOTAL -->
                <td>
                    {{ $items->sum('jumlah') }}
                </td>

                <!-- AKSI -->
                <td>
                    @foreach($items as $r)
                        <form action="{{ route('resep.destroy', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1">
                                Hapus
                            </button>
                        </form>
                    @endforeach
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    Belum ada resep
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

</div>
@endsection