<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 30%;
            background-color: #f5f5f5;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h4 {
            margin-bottom: 10px;
            font-size: 14px;
            border-left: 4px solid #007bff;
            padding-left: 8px;
            color: #007bff;
        }

        .section p {
            margin: 0;
            line-height: 1.5;
        }

        .bukti-box {
            border: 1px solid #ddd;
            background-color: #fafafa;
            padding: 10px;
            margin-top: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h2>Detail Laporan</h2>

    <table>
        <tr>
            <td class="label">ID Pelapor</td>
            <td>{{ $laporan->id_pelapor }}</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td>{{ $laporan->nama ?? 'Anonim' }}</td>
        </tr>
        <tr>
            <td class="label">No HP</td>
            <td>{{ $laporan->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>{{ $laporan->email ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Judul</td>
            <td>{{ $laporan->judul }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td>{{ $laporan->nama_category }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>
                @if ($laporan->status_jawab == 0)
                    Proses
                @else
                    Selesai
                @endif
            </td>
        </tr>
    </table>

    <div class="section">
        <h4>Deskripsi Kejadian</h4>
        <p>{{ $laporan->deskripsi }}</p>
    </div>

    <div class="section">
        <h4>Tindak Lanjut</h4>
        <p><strong>Tindakan:</strong> {{ $laporan->tindak_lanjut ?? '-' }}</p>
        <p><strong>Catatan:</strong></p>
        <p>{{ $laporan->catatan_tindak_lanjut ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Bukti</h4>
        @if ($laporan->bukti)
            <div class="bukti-box">
                Tersedia: {{ $laporan->bukti }}
            </div>
        @else
            <div class="bukti-box">
                Tidak ada bukti terlampir.
            </div>
        @endif
    </div>
</body>

</html>
