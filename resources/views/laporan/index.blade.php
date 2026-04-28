@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
body {
    background-color: #f4f6f9;
    font-family: 'Montserrat', sans-serif;
}

/* HEADER */
.judul {
    color: #e4002b;
    font-weight: 800;
    text-transform: uppercase;
    border-left: 5px solid #ffc107;
    padding-left: 15px;
}

/* CARD */
.card-custom {
    border-radius: 15px;
    border: none;
}

/* BUTTON */
.btn-merah {
    background: #e4002b;
    color: white;
    font-weight: 700;
    border-radius: 8px;
}

.btn-merah:hover {
    background: #b30022;
}

/* SUMMARY */
.card-summary {
    border-radius: 15px;
    padding: 20px;
    color: white;
}

.bg-merah {
    background: linear-gradient(135deg, #e4002b, #b30022);
}

.bg-hitam {
    background: linear-gradient(135deg, #2b2b2b, #000);
}

/* TABLE */
.thead-custom {
    background: #ffc107;
}

.thead-custom th {
    font-size: 12px;
    font-weight: 700;
}

/* BADGE */
.badge-metode {
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: 700;
}

.badge-cash {
    background: #28a745;
    color: white;
}

.badge-qris {
    background: #007bff;
    color: white;
}
</style>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div>
                <h3 class="judul mb-0">Laporan Keuangan</h3>
                <small class="text-muted">Monitoring penjualan & transaksi</small>
            </div>
        </div>

    </div>

    <!-- FILTER -->
    <div class="card card-custom shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <select name="cabang_id" class="form-control">
                        <option value="">Semua Cabang</option>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ request('cabang_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="metode" class="form-control">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('metode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-merah w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('laporan.pdf', request()->query()) }}" 
        class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>

        <a href="{{ route('laporan.excel', request()->query()) }}" 
        class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>

    <!-- SUMMARY -->
    <div class="row mb-4">

        <div class="col-md-6">
            <div class="card-summary bg-merah shadow-sm">
                <h6>Total Penjualan</h6>
                <h3>Rp {{ number_format($total) }}</h3>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-summary bg-hitam shadow-sm">
                <h6>Jumlah Transaksi</h6>
                <h3>{{ $jumlah }}</h3>
            </div>
        </div>

    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">
                    📈 Grafik Penjualan Harian
                </div>
                <div class="card-body">
                    <canvas id="chartHarian"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">
                    🏪 Grafik Penjualan per Cabang
                </div>
                <div class="card-body">
                    <canvas id="chartCabang"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card card-custom shadow-sm mb-4">
        <div class="card-header fw-bold">
            <i class="fas fa-receipt me-2 text-danger"></i>Detail Transaksi
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">

                <thead class="thead-custom">
                    <tr>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Metode</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td>{{ $t->tanggal }}</td>
                        <td>
                            <span class="badge bg-dark">
                                {{ $t->cabang->nama_cabang ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $t->menu->nama_menu ?? '-' }}</td>
                        <td>{{ $t->qty }}</td>

                        <td>
                            @if($t->metode_pembayaran == 'cash')
                                <span class="badge-metode badge-cash">CASH</span>
                            @else
                                <span class="badge-metode badge-qris">QRIS</span>
                            @endif
                        </td>

                        <td class="fw-bold text-danger">
                            Rp {{ number_format($t->total) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <!-- TOTAL PER METODE -->
    <div class="row">
        @foreach($totalPerMetode as $m)
        <div class="col-md-4">
            <div class="card card-custom shadow-sm p-3 text-center">
                <h6>Total {{ strtoupper($m->metode_pembayaran) }}</h6>
                <h5 class="text-danger fw-bold">
                    Rp {{ number_format($m->total) }}
                </h5>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const harianLabels = {!! json_encode($perHari->pluck('tanggal')) !!};
const harianData = {!! json_encode($perHari->pluck('total')) !!};

new Chart(document.getElementById('chartHarian'), {
    type: 'line',
    data: {
        labels: harianLabels,
        datasets: [{
            label: 'Penjualan Harian',
            data: harianData,
            tension: 0.4,
            fill: true
        }]
    }
});

const cabangLabels = {!! json_encode($perCabang->pluck('cabang.nama_cabang')) !!};
const cabangData = {!! json_encode($perCabang->pluck('total')) !!};

new Chart(document.getElementById('chartCabang'), {
    type: 'bar',
    data: {
        labels: cabangLabels,
        datasets: [{
            label: 'Total',
            data: cabangData
        }]
    }
});
</script>

@endpush