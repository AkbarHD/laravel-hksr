<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StackholderController extends Controller
{
    public function laporanPending()
    {
        $laporanMasuk = DB::table('pelapors')
            ->join('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select(
                'pelapors.id',
                'pelapors.id_pelapor',
                'pelapors.judul',
                'pelapors.deskripsi',
                'pelapors.nama',
                'pelapors.no_hp',
                'pelapors.email',
                'pelapors.bukti',
                'pelapors.catatan',
                'pelapors.created_at',
                'categories.nama_category',
                'jawab_pelapor.id as jawab_id',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                'jawab_pelapor.status as status_jawab'
            )
            ->where('pelapors.status', 1)
            ->where('pelapors.isdelete', '0')
            ->where('jawab_pelapor.isdelete', '0')
            ->orderBy('jawab_pelapor.status', 'asc') // Prioritaskan status 0 (Proses)
            ->orderBy('pelapors.created_at', 'desc') // Baru urutkan berdasarkan tanggal
            ->get();

        return view('admin.stackholder.index', compact('laporanMasuk'));
    }


    // Get laporan untuk modal
    public function getLaporan($id)
    {
        $laporan = DB::table('jawab_pelapor')
            ->join('pelapors', 'jawab_pelapor.pelapor_id', '=', 'pelapors.id')
            ->select('pelapors.*')
            ->where('jawab_pelapor.id', $id)
            ->first();

        return response()->json($laporan);
    }

    // Simpan tindak lanjut
    public function simpanTindakLanjut(Request $request)
    {
        $request->validate([
            'tindak_lanjut' => 'required|string',
            'catatan_tindak_lanjut' => 'required|string',
            'jawab_id' => 'required|integer'
        ]);

        DB::table('jawab_pelapor')
            ->where('id', $request->jawab_id)
            ->update([
                'tindak_lanjut' => $request->tindak_lanjut,
                'catatan_tindak_lanjut' => $request->catatan_tindak_lanjut,
                'status' => 1,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function getLaporanById($id)
    {
        $laporan = DB::table('pelapors')
            ->join('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select(
                'pelapors.id_pelapor',
                'pelapors.nama',
                'pelapors.no_hp',
                'pelapors.email',
                'pelapors.judul',
                'pelapors.deskripsi',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                'jawab_pelapor.status as status_jawab'
            )
            ->where('jawab_pelapor.id', $id)
            ->first();

        return response()->json($laporan);
    }

    public function hasilTindakLanjut()
    {
        $userId = auth()->id();

        $hasilTindakLanjut = DB::table('pelapors')
            ->join('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->join('users', 'pelapors.user_id', '=', 'users.id')
            ->select(
                'pelapors.id',
                'pelapors.id_pelapor',
                'pelapors.judul',
                'pelapors.deskripsi',
                'pelapors.created_at',
                'categories.nama_category',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                'jawab_pelapor.status as status_jawab'
            )
            ->where('pelapors.user_id', $userId)
            ->where('pelapors.status', 1) // sudah diverifikasi
            ->where('jawab_pelapor.status', 1) // sudah selesai
            ->where('pelapors.isdelete', '0')
            ->where('jawab_pelapor.isdelete', '0')
            ->orderBy('pelapors.created_at', 'desc')
            ->get();

        return view('admin.list_laporan.hasil_tindaklanjut', compact('hasilTindakLanjut'));
    }

    public function downloadPDF($id)
    {
        $laporan = DB::table('pelapors')
            ->join('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select(
                'pelapors.id_pelapor',
                'pelapors.judul',
                'pelapors.deskripsi',
                'pelapors.nama',
                'pelapors.no_hp',
                'pelapors.email',
                'pelapors.bukti',
                'pelapors.catatan',
                'pelapors.created_at',
                'categories.nama_category',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                'jawab_pelapor.status as status_jawab'
            )
            ->where('jawab_pelapor.id', $id)
            ->first();

        if (!$laporan) {
            abort(404);
        }

        $pdf = Pdf::loadView('admin.stackholder.laporan_pdf', compact('laporan'))->setPaper('A4');
        return $pdf->download('Laporan_' . $laporan->id_pelapor . '.pdf');
    }
}
