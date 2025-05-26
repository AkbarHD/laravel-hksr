<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginProses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('homeadmin');
        } else {
            return back()->withErrors(['errors' => 'Email atau password salah.'])->withInput();
        }
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function registerProses(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                if ($existingUser->is_useractive == 0 || $existingUser->is_useractive == 1) {
                    return redirect()->back()->with('error', 'Email sudah terdaftar dan sedang dalam proses verifikasi atau sudah aktif.');
                }
            }
            // jika click logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '_' . $logo->getClientOriginalName();
                $logoPath = 'uploads/logo/' . $logoName; // masuk ke dalam db

                $logo->move(public_path('uploads/logo'), $logoName);
            }

            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $logoPath,
                'password' => bcrypt($request->password),
                'gender' => $request->gender,
                'role' => 3,
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('daily')->error('Failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->with(['error' => 'Gagal simpan!']);
        }


        // return redirect()->back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }



}
