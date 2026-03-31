@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Montserrat', sans-serif;
    }

    /* Header & Card Styling */
    .card-kasir {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .card-header-kfc {
        background: linear-gradient(135deg, #e4002b 0%, #b30022 100%);
        color: white;
        padding: 25px;
        border-bottom: 5px solid #ffc107; /* Aksen Kuning */
    }

    .card-header-kfc h4 {
        font-weight: 800;
        letter-spacing: 1px;
    }

    /* Form Elements */
    .form-label-custom {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #666;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .input-kfc {
        border-radius: 12px !important;
        border: 2px solid #eee !important;
        padding: 12px 15px !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .input-kfc:focus {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15) !important;
        background-color: #fff;
    }

    /* Total Section */
    .total-box {
        background-color: #fff3cd;
        border: 2px dashed #ffc107;
        border-radius: 12px;
        padding: 15px;
    }

    .display-total {
        font-size: 2rem;
        font-weight: 800;
        color: #e4002b;
        margin: 0;
    }

    /* Button Styling */
    .btn-kfc-red {
        background-color: #e4002b;
        border: none;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        padding: 15px 35px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .btn-kfc-red:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(228, 0, 43, 0.2);
    }

    .btn-kfc-red:disabled {
        background-color: #ccc;
        transform: none;
    }

    /* Animation */
    @keyframes pulse-yellow {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    .stok-aman { color: #198754; font-size: 12px; }
    .stok-bahaya { color: #dc3545; font-size: 12px; animation: pulse-yellow 1s infinite; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-times-circle me-3 fs-4"></i>
                        <div><strong>Gagal!</strong> {{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-kasir shadow-lg">
                <div class="card-header card-header-kfc text-center">
                    <h4 class="mb-0"><i class="fas fa-cash-register me-2 text-warning"></i> POS - KASIR</h4>
                    <p class="small mb-0 opacity-75 fw-semibold mt-1">Sistem Input Penjualan Real-Time</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('kasir.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label-custom">Lokasi Transaksi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0 rounded-start-3"><i class="fas fa-store text-danger"></i></span>
                                <select name="cabang_id" class="form-select input-kfc border-start-0" required>
                                    <option value="" selected disabled>-- Pilih Cabang --</option>
                                    @foreach($cabang as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">Menu Pesanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0 rounded-start-3"><i class="fas fa-utensils text-danger"></i></span>
                                <select name="menu_id" id="menu_id" class="form-select input-kfc border-start-0" required>
                                    <option value="" selected disabled>-- Ketik atau Cari Menu --</option>
                                    @foreach($menu as $m)
                                        <option value="{{ $m->id }}" data-harga="{{ $m->harga }}" data-stok="{{ $m->stok }}">
                                            {{ $m->nama_menu }} — Rp {{ number_format($m->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label-custom">Kuantitas (Qty)</label>
                                <input type="number" name="qty" id="qty" class="form-control input-kfc text-center fs-5 shadow-sm" min="1" value="1" required>
                                <div id="stok_warning" class="mt-2 text-center fw-bold"></div>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label-custom">Ringkasan Total</label>
                                <div class="total-box text-center shadow-sm">
                                    <span class="small fw-bold text-muted d-block mb-1">TOTAL BAYAR (IDR)</span>
                                    <h2 id="total_display" class="display-total">0</h2>
                                    <input type="hidden" name="total" id="total_input">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-5">
                            <a href="{{ route('kasir.index') }}" class="text-decoration-none text-muted fw-bold order-2 order-md-1">
                                <i class="fas fa-times me-1 text-danger"></i> Batalkan Pesanan
                            </a>
                            <button type="submit" id="btn-submit" class="btn btn-kfc-red px-5 shadow order-1 order-md-2 w-100 w-md-auto">
                                <i class="fas fa-check-circle me-2"></i> Proses Transaksi
                            </button>
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

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0
        }).format(number);
    }

    function hitungDanValidasi() {
        if (menuSelect.selectedIndex <= 0) return;

        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
        const stokTersedia = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        const qtyDiminta = parseInt(qtyInput.value) || 0;

        // Hitung Total
        const total = harga * qtyDiminta;
        totalDisplay.innerText = formatRupiah(total);
        totalInput.value = total;

        // Validasi Stok
        if (qtyDiminta > stokTersedia) {
            stokWarning.innerHTML = `<span class="stok-bahaya"><i class="fas fa-times-circle me-1"></i> Stok Terbatas (${stokTersedia})</span>`;
            qtyInput.style.borderColor = "#dc3545";
            btnSubmit.disabled = true;
        } else if (qtyDiminta > 0) {
            stokWarning.innerHTML = `<span class="stok-aman"><i class="fas fa-check-circle me-1"></i> Tersedia (${stokTersedia})</span>`;
            qtyInput.style.borderColor = "#eee";
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }

    menuSelect.addEventListener('change', hitungDanValidasi);
    qtyInput.addEventListener('input', hitungDanValidasi);
</script>
@endsection