<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kategori {{ $kategori->kode }}</title>
    <style>
        @page {
            margin: 40px 40px 70px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .right {
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            font-size: 10px;
            border-top: 1px solid #999;
            padding-top: 4px;
        }
    </style>
</head>

<body>
    <h2>Detail Kategori</h2>
    <p>
        Nama Kategori: <strong>{{ $kategori->nama }}</strong><br>
        Kode Kategori: <strong>{{ $kategori->kode }}</strong>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Supplier</th>
                <th class="right">Harga Beli</th>
                <th class="right">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td class="right">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="right">
                        {{ number_format($item->harga_beli + ($item->harga_beli * $item->laba) / 100, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada item pada kategori ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <footer>Dicetak pada: {{ $dicetak->format('d-m-Y H:i:s') }} WITA</footer>
</body>

</html>
