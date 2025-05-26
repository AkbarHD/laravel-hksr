<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function pelaporan()
    {
        $pelapors = DB::table('pelapors')
            ->join('users', 'pelapors.user_id', '=', 'users.id')
            ->select('pelapors.*', 'users.id as user_id')
            ->where('pelapors.user_id', '=', auth()->user()->id)
            ->where('pelapors.isdelete', 0)
            ->orderBy('pelapors.created_at', 'desc')
            ->limit(5)
            ->get();
        $categories = DB::table('categories')->where('isdelete', 0)->get();
        return view('frontend.pelaporan', compact('categories', 'pelapors'));
    }

    public function modul(Request $request)
    {
        try {
            $search = $request->get('search');
            $category = $request->get('category');

            $query = DB::table('modul')
                ->join('categories', 'modul.category_id', '=', 'categories.id')
                ->select(
                    'modul.*',
                    'categories.nama_category'
                )
                ->where('modul.isdelete', '0')
                ->where('categories.isdelete', '0');

            // Filter berdasarkan pencarian
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('modul.judul', 'LIKE', "%{$search}%")
                        ->orWhere('modul.isi', 'LIKE', "%{$search}%")
                        ->orWhere('categories.nama_category', 'LIKE', "%{$search}%");
                });
            }

            // Filter berdasarkan kategori
            if ($category) {
                $query->where('modul.category_id', $category);
            }

            $moduls = $query->orderBy('modul.created_at', 'desc')->paginate(9);

            // Get categories untuk filter
            $categories = DB::table('categories')
                ->where('isdelete', '0')
                ->orderBy('nama_category')
                ->get();

            return view('frontend.modul', compact('moduls', 'categories', 'search', 'category'));

        } catch (Exception $e) {
            Log::channel('daily')->error('Error saat load halaman modul', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'ip_address' => $request->ip()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman modul.');
        }
    }

    public function detailModul($slug)
    {
        try {
            $modul = DB::table('modul')
                ->join('categories', 'modul.category_id', '=', 'categories.id')
                ->select(
                    'modul.*',
                    'categories.nama_category'
                )
                ->where('modul.slug', $slug)
                ->where('modul.isdelete', '0')
                ->where('categories.isdelete', '0')
                ->first();

            if (!$modul) {
                return redirect()->route('modul')->with('error', 'Modul tidak ditemukan.');
            }

            return view('frontend.detail_modul', compact('modul'));

        } catch (Exception $e) {
            Log::channel('daily')->error('Error saat load detail modul', [
                'error_message' => $e->getMessage(),
                'slug' => $slug,
                'ip_address' => request()->ip()
            ]);

            return redirect()->route('modul')->with('error', 'Terjadi kesalahan saat memuat detail modul.');
        }
    }
}
