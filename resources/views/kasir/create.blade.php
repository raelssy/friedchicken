@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                        <div>
                            <strong>Gagal Simpan!</strong> {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i> Input Transaksi Baru</h4>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('kasir.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Cabang</label>
                            <select name="cabang_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="" selected disabled>-- Pilih Cabang Transaksi --</option>
                                @foreach($cabang as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Menu</label>
                            <select name="menu_id" id="menu_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="" selected disabled>-- Cari Menu --</option>
                                @foreach($menu as $m)
                                    {{-- Penting: Atribut data-stok dan data-harga digunakan untuk Javascript --}}
                                    <option value="{{ $m->id }}" data-harga="{{ $m->harga }}" data-stok="{{ $m->stok }}">
                                        {{ $m->nama_menu }} — Rp {{ number_format($m->harga, 0, ',', '.') }} (Sisa Stok: {{ $m->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Jumlah (Qty)</label>
                                <input type="number" name="qty" id="qty" class="form-control form-control-lg shadow-sm" min="1" value="1" required>
                                <div id="stok_warning" class="small mt-1 fw-bold"></div>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Total Pembayaran</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="total_display" class="form-control form-control-lg bg-white fw-bold text-primary" readonly>
                                    <input type="hidden" name="total" id="total_input">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kasir.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" id="btn-submit" class="btn btn-primary btn-lg px-5 shadow">Simpan Transaksi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const menuSelect = document.getElementById('menu_id');
    const qtyInput = document.getElementById('qty');
    const totalDisplay = document.getElementById('total_display');
    const totalInput = document.getElementById('total_input');
    const stokWarning = document.getElementById('stok_warning');
    const btnSubmit = document.getElementById('btn-submit');

    function hitungDanValidasi() {
        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        
        // Ambil data dari atribut 'data-' di option yang dipilih
        const harga = selectedOption.getAttribute('data-harga') || 0;
        const stokTersedia = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        const qtyDiminta = parseInt(qtyInput.value) || 0;

        // 1. Hitung Total Harga
        const total = harga * qtyDiminta;
        totalDisplay.value = new Intl.NumberFormat('id-ID').format(total);
        totalInput.value = total;

        // 2. Cek apakah Qty melebihi stok yang ada
        if (menuSelect.value !== "") {
            if (qtyDiminta > stokTersedia) {
                stokWarning.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle"></i> Stok tidak cukup! Maksimal: ${stokTersedia}</span>`;
                qtyInput.classList.add('is-invalid');
                btnSubmit.disabled = true; // Kunci tombol simpan jika stok kurang
            } else {
                stokWarning.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> Stok tersedia</span>`;
                qtyInput.classList.remove('is-invalid');
                btnSubmit.disabled = false; // Buka tombol simpan jika stok aman
            }
        }
    }

    menuSelect.addEventListener('change', hitungDanValidasi);
    qtyInput.addEventListener('input', hitungDanValidasi);
</script>
@endsection