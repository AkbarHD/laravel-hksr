<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PelaporController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'judul' => 'required|string|max:100',
                'category_id' => 'required|exists:categories,id',
                'deskripsi' => 'required|string',
                'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
                'identityType' => 'required|in:anonim,identitas',
                'nama' => 'nullable|string|max:100',
                'no_hp' => 'nullable|string|max:100',
                'email' => 'nullable|email|max:100'
            ]);

            // Generate ID pelapor unik
            $idPelapor = 'LP' . date('Ymd') . rand(1000, 9999);

            // Cek apakah ID sudah ada, jika ya generate ulang
            while (DB::table('pelapors')->where('id_pelapor', $idPelapor)->exists()) {
                $idPelapor = 'LP' . date('Ymd') . rand(1000, 9999);
            }

            // Handle upload bukti jika ada
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $buktiPath = $file->storeAs('bukti_pelaporan', $fileName, 'public');
            }

            // Prepare data untuk insert
            $dataInsert = [
                'id_pelapor' => $idPelapor,
                'user_id' => auth()->user()->id,
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'deskripsi' => $request->deskripsi,
                'bukti' => $buktiPath,
                'status' => 0, // 0 = Menunggu verifikasi
                'isdelete' => '0',
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Jika bukan anonim, tambahkan data identitas
            if ($request->identityType === 'identitas') {
                $dataInsert['nama'] = $request->nama;
                $dataInsert['no_hp'] = $request->no_hp;
                $dataInsert['email'] = $request->email;
            }

            // Insert data ke database
            $insertId = DB::table('pelapors')->insertGetId($dataInsert);

            // Kirim notifikasi ke semua admin
            $admins = DB::table('users')->where('role', 1)->get();

            foreach ($admins as $admin) {
                DB::table('notifications')->insert([
                    'user_id' => $admin->id,
                    'title' => 'Laporan Baru Masuk',
                    'message' => 'Laporan dari ' . auth()->user()->name . ' dengan judul "' . $request->judul . '" telah dikirim.',
                    'is_read' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Redirect dengan pesan sukses dan ID pelapor
            return redirect()->back()->with('success', 'Laporan berhasil dibuat.');
        } catch (Exception $e) {
            // Log general error
            Log::channel('daily')->error('Error saat menyimpan pelaporan', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'input' => $request->except(['bukti', '_token']),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Jika ada file yang sudah diupload, hapus file tersebut
            if (isset($buktiPath) && $buktiPath && Storage::disk('public')->exists($buktiPath)) {
                Storage::disk('public')->delete($buktiPath);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan laporan.']);
        }
    }
}
