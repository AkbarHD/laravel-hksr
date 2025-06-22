<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Laporan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 8px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .label {
            width: 30%;
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="title">Detail Laporan</div>
    <table>
        <tr>
            <td class="label">ID Pelapor</td>
            <td>{{ $laporan->id_pelapor }}</td>
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
            <td class="label">Status</td>
            <td>{{ $laporan->status_text }}</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td>{{ $laporan->nama ?? 'Anonim' }}</td>
        </tr>
        <tr>
            <td class="label">No HP</td>
            <td>{{ $laporan->no_hp }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>{{ $laporan->email }}</td>
        </tr>
        <tr>
            <td class="label">Deskripsi</td>
            <td>{{ $laporan->deskripsi }}</td>
        </tr>
        <tr>
            <td class="label">Catatan</td>
            <td>{{ $laporan->catatan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tindak Lanjut</td>
            <td>{{ $laporan->tindak_lanjut ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Catatan Tindak Lanjut</td>
            <td>{{ $laporan->catatan_tindak_lanjut ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Bukti</td>
            <td>
                @if ($laporan->bukti)
                    Disertakan: {{ $laporan->bukti }}
                @else
                    Tidak ada bukti
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Dibuat Pada</td>
            <td>{{ $laporan->created_at }}</td>
        </tr>
    </table>
</body>

</html>
