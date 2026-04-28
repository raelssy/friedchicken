<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #e4002b;
            color: white;
            padding: 8px;
            text-align: left;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h2>LAPORAN KEUANGAN</h2>
        <p>FnB Fried Chicken</p>
    </div>

    <!-- FILTER INFO -->
    <div class="summary">
        <p><strong>Periode:</strong> {{ request('dari') ?? '-' }} s/d {{ request('sampai') ?? '-' }}</p>
        <p><strong>Metode:</strong> {{ request('metode') ?? 'Semua' }}</p>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
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
            @foreach($data as $t)
            <tr>
                <td>{{ $t->tanggal }}</td>
                <td>{{ $t->cabang->nama_cabang ?? '-' }}</td>
                <td>{{ $t->menu->nama_menu ?? '-' }}</td>
                <td>{{ $t->qty }}</td>
                <td>{{ strtoupper($t->metode_pembayaran) }}</td>
                <td>Rp {{ number_format($t->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total">
        Total Pendapatan: Rp {{ number_format($data->sum('total')) }}
    </div>

</body>
</html>