<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ModulController extends Controller
{
    public function index()
    {
        $moduls = DB::table('modul')
            ->join('categories', 'modul.category_id', '=', 'categories.id')
            ->select('modul.*', 'categories.nama_category')
            ->where('modul.isdelete', 0)
            ->where('categories.isdelete', 0)
            ->get();
        $categories = DB::table('categories')->where('isdelete', 0)->get();
        return view('admin.modul.index', compact('moduls', 'categories'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $request->validate([
                'judul' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'gambar' => 'required|mimes:jpeg,png,jpg|max:2048',
                'isi' => 'required|string',
            ]);

            // Default path kosong
            $gambarPath = null;

            // Jika ada file gambar diupload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/modul'), $filename); // simpan ke /public/uploads/products
                $gambarPath = 'uploads/modul/' . $filename;
            }

            // Simpan data ke database pakai query builder
            DB::table('modul')->insert([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'gambar' => $gambarPath,
                'isi' => $request->isi,
                'isdelete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Materi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Failed to tambah Materi', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal Tambah Materi.']);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $modul = DB::table('modul')->where('id', $id)->first();

        if (!$modul) {
            return response()->json(['error' => 'Data Modul tidak ditemukan'], 404);
        }

        $categories = DB::table('categories')->where('isdelete', 0)->get(); // penting

        return view('admin.modul.edit', compact('modul', 'categories'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'isi' => 'required|string',
                'gambar' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ]);

            $modul = DB::table('modul')->where('id', $id)->first();

            if (!$modul) {
                return redirect()->back()->withErrors(['error' => 'modul tidak ditemukan.']);
            }

            $gambarPath = $modul->gambar;

            // Jika gambar baru diupload
            if ($request->hasFile('gambar')) {
                if ($gambarPath && file_exists(public_path($gambarPath))) {
                    unlink(public_path($gambarPath));
                }

                $file = $request->file('gambar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/modul'), $filename);
                $gambarPath = 'uploads/modul/' . $filename;
            }

            DB::table('modul')->where('id', $id)->update([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'isi' => $request->isi,
                'gambar' => $gambarPath,
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Modul berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Modul Modul gagal', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat update Modul.']);
        }
    }

    public function detail(Request $request)
    {
        $modul = DB::table('modul')
            ->join('categories', 'modul.category_id', '=', 'categories.id')
            ->select('modul.*', 'categories.nama_category')
            ->where('modul.id', $request->id)
            ->where('modul.isdelete', 0)
            ->first();

        if (!$modul) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return view('admin.modul.detail', compact('modul'));
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $modul = DB::table('modul')->where('id', $id)->first();

            if (!$modul) {
                return redirect()->back()->withErrors(['error' => 'modul tidak ditemukan.']);
            }

            // Hapus file gambar jika ada
            if ($modul->gambar && file_exists(public_path($modul->gambar))) {
                unlink(public_path($modul->gambar));
            }

            // Soft delete (set isdelete = 1)
            DB::table('modul')->where('id', $id)->update([
                'isdelete' => 1,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'modul berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Gagal hapus modul', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Gagal hapus modul.']);
        }
    }
}
