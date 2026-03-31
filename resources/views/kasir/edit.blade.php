@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Montserrat', sans-serif;
    }

    .form-edit-transaksi {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Header Styling - Kuning untuk fase Edit */
    .card-header-edit {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #432C1E;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }

    .card-header-edit h5 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    /* Input Styling */
    .label-custom {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-custom {
        border-radius: 10px;
        border: 2px solid #eee;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .form-control-custom:focus {
        border-color: #e4002b;
        box-shadow: 0 0 0 0.25rem rgba(228, 0, 43, 0.1);
    }

    /* Total Section */
    .total-display-box {
        background-color: #fff3cd;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 2px dashed #ffc107;
    }

    .total-amount {
        font-size: 1.8rem;
        font-weight: 800;
        color: #e4002b;
    }

    /* Button Styling */
    .btn-update-transaksi {
        background-color: #e4002b;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        padding: 14px;
        border: none;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-update-transaksi:hover {
        background-color: #b30022;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(228, 0, 43, 0.2);
    }
</style>

<div class="container py-5">
    <div class="form-edit-transaksi">
        
        <nav class="mb-3">
            <a href="{{ route('kasir.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-chevron-left me-1"></i> Kembali ke Riwayat Transaksi
            </a>
        </nav>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header card-header-edit">
                <div class="d-flex align-items-center">
                    <i class="fas fa-edit me-3 fa-lg"></i>
                    <h5>Edit Detail Transaksi</h5>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="/kasir/update/{{ $transaksi->id }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="label-custom">Menu Terpilih</label>
                        <select name="menu_id" id="menu_id" class="form-select form-control-custom shadow-sm" required>
                            @foreach($menu as $m)
                                <option value="{{ $m->id }}" 
                                    data-harga="{{ $m->harga }}"
                                    {{ $transaksi->menu_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_menu }} — Rp {{ number_format($m->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="label-custom">Kuantitas (Qty)</label>
                            <input type="number" name="qty" id="qty" 
                                   class="form-control form-control-custom text-center shadow-sm" 
                                   value="{{ $transaksi->qty }}" min="1" required>
                        </div>

                        <div class="col-md-8">
                            <label class="label-custom">Total Pembayaran Baru</label>
                            <div class="total-display-box shadow-sm">
                                <span class="small fw-bold text-muted d-block mb-1">TOTAL (IDR)</span>
                                <div class="total-amount" id="total_formatted">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
                                <input type="hidden" name="total" id="total_input" value="{{ $transaksi->total }}">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-update-transaksi">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1 text-warning"></i> Perubahan transaksi akan secara otomatis menyesuaikan stok menu kembali.
            </small>
        </div>
    </div>
</div>

<script>
    const menuSelect = document.getElementById('menu_id');
    const qtyInput = document.getElementById('qty');
    const totalFormatted = document.getElementById('total_formatted');
    const totalInput = document.getElementById('total_input');

    function updatePrice() {
        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
        const qty = parseInt(qtyInput.value) || 0;

        const total = harga * qty;

        // Update UI
        totalFormatted.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        totalInput.value = total;
    }

    // Jalankan fungsi saat ada perubahan input
    menuSelect.addEventListener('change', updatePrice);
    qtyInput.addEventListener('input', updatePrice);
</script>
@endsection