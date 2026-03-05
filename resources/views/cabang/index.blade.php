@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Data Cabang</h3>

    <a href="/cabang/create" class="btn btn-primary">
        Tambah Cabang
    </a>
</div>

<table class="table table-bordered table-striped">

    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Cabang</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @foreach($cabang as $index => $c)

        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $c->nama_cabang }}</td>
            <td>{{ $c->alamat }}</td>
            <td>{{ $c->telepon }}</td>

            <td>

                <a href="/cabang/edit/{{ $c->id }}" 
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a href="/cabang/delete/{{ $c->id }}"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin hapus?')">
                    Hapus
                </a>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@endsection