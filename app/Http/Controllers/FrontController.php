<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

            $query = DB::table('modul')

                ->select(
                    'modul.*',
                )
                ->where('isdelete', '0');

            // Filter berdasarkan pencarian
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'LIKE', "%{$search}%")
                        ->orWhere('isi', 'LIKE', "%{$search}%");
                });
            }


            $moduls = $query->orderBy('created_at', 'desc')->paginate(9);

            return view('frontend.modul', compact('moduls', 'search'));
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
                ->select(
                    'modul.*',
                )
                ->where('slug', $slug)
                ->where('isdelete', '0')
                ->first();

            if (!$modul) {
                return redirect()->route('modul')->with('error', 'Modul tidak ditemukan.');
            }

            // jika dia masuk ke halaman detail modul, maka viewsnya akan bertambah 1
            DB::table('modul')->where('id', $modul->id)->increment('views');

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

    // untuk mengunduh modul dalam format PDF
    public function downloadModulPdf($id)
    {
        $modul = DB::table('modul')
            ->select('modul.*')
            ->where('id', $id)
            ->where('isdelete', '0')
            ->first();

        if (!$modul) {
            return redirect()->back()->with('error', 'Modul tidak ditemukan.');
        }

        $pdf = Pdf::loadView('frontend.pdf.modul', compact('modul'));
        return $pdf->download(Str::slug($modul->judul) . '.pdf');
    }
}
