<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ListLaporanController extends Controller
{
    public function index()
    {
        //
        $listLaporans = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select('pelapors.*', 'categories.nama_category')
            ->where('pelapors.isdelete', 0)
            ->where('pelapors.user_id', auth()->user()->id)
            ->orderBy('pelapors.created_at', 'desc')
            ->get();
        return view('admin.list_laporan.index', compact('listLaporans'));
    }

    public function show($id)
    {
        $laporan = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select(
                'pelapors.*',
                'categories.nama_category'
            )
            ->where('pelapors.id', $id)
            ->first();

        return response()->json($laporan);
    }

    public function destroy($id)
    {
        $laporan = DB::table('pelapors')->where('id', $id)->first();

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file jika ada dan file memang disimpan
        if ($laporan->bukti && Storage::disk('public')->exists($laporan->bukti)) {
            Storage::disk('public')->delete($laporan->bukti);
        }

        // Update isdelete = 1 (soft delete manual)
        DB::table('pelapors')->where('id', $id)->update([
            'isdelete' => 1,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function pendingLaporan()
    {
        $laporanPending = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->select('pelapors.*', 'categories.nama_category')
            ->where('pelapors.isdelete', 0)
            ->orderBy('pelapors.status', 'asc')
            ->orderBy('pelapors.created_at', 'desc')
            ->get();

        return view('admin.list_laporan.laporan_pending', compact('laporanPending'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        // Update pelapor pakai query builder
        DB::table('pelapors')->where('id', $id)->update([
            'status' => 1,
            'catatan' => $request->catatan,
            'updated_at' => now()
        ]);

        // Insert ke jawab_pelapor
        DB::table('jawab_pelapor')->insert([
            'pelapor_id' => $id,
            'tindak_lanjut' => null,
            'catatan_tindak_lanjut' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ambil data pelapor untuk tahu user_id
        $pelapor = DB::table('pelapors')->where('id', $id)->first();

        // Notifikasi ke user
        DB::table('notifications')->insert([
            'user_id' => $pelapor->user_id,
            'title' => 'Laporan Anda Diverifikasi',
            'message' => 'Laporan Anda telah diverifikasi. Silakan tunggu tindak lanjut dari stackholder.',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Notifikasi ke semua staff (role = 2)
        $staffs = DB::table('users')->where('role', 2)->get();
        foreach ($staffs as $staff) {
            DB::table('notifications')->insert([
                'user_id' => $staff->id,
                'title' => 'Laporan Baru untuk Ditindaklanjuti',
                'message' => 'Ada laporan yang telah diverifikasi dan perlu ditindaklanjuti.',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


        return redirect()->back()->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        DB::table('pelapors')->where('id', $id)->update([
            'status' => 2, // Ditolak
            'catatan' => $request->catatan,
            'updated_at' => now()
        ]);

        // Ambil data pelapor untuk tahu user_id
        $pelapor = DB::table('pelapors')->where('id', $id)->first();

        // Notifikasi ke user
        DB::table('notifications')->insert([
            'user_id' => $pelapor->user_id,
            'title' => 'Laporan Anda Ditolak',
            'message' => 'Laporan Anda ditolak. Catatan: ' . $request->catatan,
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        return redirect()->back()->with('success', 'Laporan ditolak.');
    }

    public function getDetail($id)
    {
        $laporan = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            // kenapa left join jawab_pelapor? karena tidak semua laporan punya tindak lanjut (bisa kosong)
            ->leftJoin('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->select(
                'pelapors.*',
                'categories.nama_category',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                DB::raw("CASE
                WHEN pelapors.status = 0 THEN 'Menunggu Verifikasi'
                WHEN pelapors.status = 1 THEN 'Terverifikasi'
                WHEN pelapors.status = 2 THEN 'Ditolak'
                ELSE 'Tidak Diketahui'
            END as status_text")
            )
            ->where('pelapors.id', $id)
            ->first();

        if (!$laporan) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json($laporan);
    }

    public function downloadPdf($id)
    {
        $laporan = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->leftJoin('jawab_pelapor', 'pelapors.id', '=', 'jawab_pelapor.pelapor_id')
            ->select(
                'pelapors.*',
                'categories.nama_category',
                'jawab_pelapor.tindak_lanjut',
                'jawab_pelapor.catatan_tindak_lanjut',
                DB::raw("CASE
                WHEN pelapors.status = 0 THEN 'Menunggu Verifikasi'
                WHEN pelapors.status = 1 THEN 'Terverifikasi'
                WHEN pelapors.status = 2 THEN 'Ditolak'
                ELSE 'Tidak Diketahui'
            END as status_text")
            )
            ->where('pelapors.id', $id)
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $pdf = PDF::loadView('admin.list_laporan.laporan-pdf', compact('laporan'));

        return $pdf->download('Laporan_' . $laporan->id_pelapor . '.pdf');
    }
}
