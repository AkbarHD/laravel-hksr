<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function homeadmin()
    {
        // Gender Pie Chart
        $genderData = DB::table('users')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();

        // Category Bar Chart
        $categoryData = DB::table('pelapors')
            ->join('categories', 'pelapors.category_id', '=', 'categories.id')
            ->where('pelapors.isdelete', '0')
            ->select('categories.nama_category', DB::raw('count(*) as total'))
            ->groupBy('categories.nama_category')
            ->get();

        // Monthly Line Chart
        $monthlyData = DB::table('pelapors')
            ->where('isdelete', '0')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $totalLaporan = DB::table('pelapors')
            ->where('isdelete', '0')
            ->count();

        // Total Dalam Proses dari table jawab_pelapor status 0
        $totalDalamProses = DB::table('jawab_pelapor')
            ->where('status', 0)
            ->where('isdelete', '0')
            ->count();

        // Total Selesai Ditangani dari table jawab_pelapor status 1
        $totalSelesai = DB::table('jawab_pelapor')
            ->where('status', 1)
            ->where('isdelete', '0')
            ->count();

        // Total Ditolak dari table pelapors status 2
        $totalDitolak = DB::table('pelapors')
            ->where('status', 2)
            ->where('isdelete', '0')
            ->count();
        return view('admin.homeadmin', compact(
            'genderData',
            'categoryData',
            'monthlyData',
            'totalLaporan',
            'totalDalamProses',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $logoPath = $user->image;
        if ($request->hasFile('image')) {
            // Delete old photo if exists
            if ($user->image && File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);
            $logoPath = 'uploads/users/' . $filename;
        }

        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'image' => $logoPath,
            'updated_at' => now(),
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
