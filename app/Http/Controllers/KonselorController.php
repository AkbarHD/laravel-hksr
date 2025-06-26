<?php
// app/Http/Controllers/KonselorController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KonselorController extends Controller
{
    // menampilkan daftar konselor aktif
    public function index()
    {
        $userId = auth()->id(); // Ambil ID user yang sedang login

        $konselors = DB::table('konselors')
            ->join('users', 'konselors.user_id', '=', 'users.id')
            ->select('konselors.*', 'users.name as user_name', 'users.email')
            ->where('konselors.is_delete', 0)
            ->where('konselors.user_id', $userId) // << Tambahan penting
            ->orderBy('konselors.created_at', 'desc')
            ->get();

        return view('admin.konselor.index', compact('konselors'));
    }


    // membuat konselor baru
    public function create()
    {
        // Ambil users dengan role konselor (4)
        $users = DB::table('users')
            ->where('role', 4)
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')->from('konselors')->where('is_delete', 0);
            })
            ->get();

        return view('admin.konselor.create', compact('users'));
    }

    // menyimpan konselor baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gambar_konselor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_konselor' => 'required|in:Konselor HKSR,Konselor Mental,Konselor Sebaya',
            'deskripsi' => 'required|string',
            'jam_aktif_awal' => 'required|date_format:H:i',
            'jam_aktif_akhir' => 'required|date_format:H:i|after:jam_aktif_awal',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar_konselor')) {
            $file = $request->file('gambar_konselor');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konselor'), $filename);
            $gambarPath = 'uploads/konselor/' . $filename;
        }

        DB::table('konselors')->insert([
            'user_id' => $request->user_id,
            'gambar_konselor' => $gambarPath,
            'jenis_konselor' => $request->jenis_konselor,
            'deskripsi' => $request->deskripsi,
            'jam_aktif_awal' => $request->jam_aktif_awal,
            'jam_aktif_akhir' => $request->jam_aktif_akhir,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('list.konselor.index')->with('success', 'Konselor berhasil ditambahkan!');
    }

    // detail konselor
    public function show($id)
    {
        $konselor = DB::table('konselors')
            ->join('users', 'konselors.user_id', '=', 'users.id')
            ->select('konselors.*', 'users.name as user_name', 'users.email')
            ->where('konselors.id', $id)
            ->where('konselors.is_delete', 0)
            ->first();

        if (!$konselor) {
            abort(404);
        }

        return view('admin.konselor.show', compact('konselor'));
    }

    // edit konselor
    public function edit($id)
    {
        $konselor = DB::table('konselors')->where('id', $id)->where('is_delete', 0)->first();

        if (!$konselor) {
            abort(404);
        }

        $users = DB::table('users')
            ->where('role', 4)
            ->where(function ($query) use ($konselor) {
                $query->whereNotIn('id', function ($subQuery) {
                    $subQuery->select('user_id')->from('konselors')->where('is_delete', 0);
                })->orWhere('id', $konselor->user_id);
            })
            ->get();

        return view('admin.konselor.edit', compact('konselor', 'users'));
    }

    // update konselor
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gambar_konselor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_konselor' => 'required|in:Konselor HKSR,Konselor Mental,Konselor Sebaya',
            'deskripsi' => 'required|string',
            'jam_aktif_awal' => 'required|',
            'jam_aktif_akhir' => 'required|after:jam_aktif_awal',
        ]);

        $konselor = DB::table('konselors')->where('id', $id)->where('is_delete', 0)->first();

        if (!$konselor) {
            abort(404);
        }

        $gambarPath = $konselor->gambar_konselor;

        if ($request->hasFile('gambar_konselor')) {
            // Hapus gambar lama jika ada
            if ($gambarPath && file_exists(public_path($gambarPath))) {
                unlink(public_path($gambarPath));
            }

            $file = $request->file('gambar_konselor');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konselor'), $filename);
            $gambarPath = 'uploads/konselor/' . $filename;
        }

        DB::table('konselors')->where('id', $id)->update([
            'user_id' => $request->user_id,
            'gambar_konselor' => $gambarPath,
            'jenis_konselor' => $request->jenis_konselor,
            'deskripsi' => $request->deskripsi,
            'jam_aktif_awal' => $request->jam_aktif_awal,
            'jam_aktif_akhir' => $request->jam_aktif_akhir,
            'updated_at' => now(),
        ]);

        return redirect()->route('list.konselor.index')->with('success', 'Konselor berhasil diupdate!');
    }

    // delete konselor (soft delete)
    public function destroy($id)
    {
        $konselor = DB::table('konselors')->where('id', $id)->where('is_delete', 0)->first();

        if (!$konselor) {
            abort(404);
        }

        // Soft delete
        DB::table('konselors')->where('id', $id)->update([
            'is_delete' => 1,
            'updated_at' => now(),
        ]);

        return redirect()->route('list.konselor.index')->with('success', 'Konselor berhasil dihapus!');
    }
}
