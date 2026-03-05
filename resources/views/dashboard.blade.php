@extends('layouts.app')

@section('content')

<h3>Dashboard POS Fried Chicken</h3>

<div class="row mt-4">

    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5>Total Penjualan Hari Ini</h5>
                <h3>Rp 0</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h3>0</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5>Menu Terjual</h5>
                <h3>0</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5>Stok Hampir Habis</h5>
                <h3>0</h3>
            </div>
        </div>
    </div>

</div>

@endsection