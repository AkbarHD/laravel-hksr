<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ManagementUserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
        return view('admin.management.index', compact('users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'role' => 'required',
                'gender' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ]);

            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/users'), $filename);
                $gambarPath = 'uploads/users/' . $filename;
            }
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'image' => $gambarPath,
                'gender' => $request->gender,
                'created_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.managament.index')->with('success', 'User Berhasil Ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Failed to Tambah User', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal Menambahkan User.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);
            }

            // Hapus file gambar jika ada
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            DB::table('users')->where('id', $id)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Gagal hapus User', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Gagal User produk.']);
        }
    }
}
