<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FrontendKonselorController extends Controller
{
    // Menampilkan daftar konselor yang aktif berdasarkan jam aktif
    public function index()
    {
        $currentTime = Carbon::now()->format('H:i:s');

        $konselors = DB::table('konselors')
            ->join('users', 'konselors.user_id', '=', 'users.id')
            ->select('konselors.*', 'users.name as user_name')
            ->where('konselors.is_delete', 0)
            ->where('konselors.jam_aktif_awal', '<=', $currentTime)
            ->where('konselors.jam_aktif_akhir', '>=', $currentTime)
            ->orderBy('konselors.jenis_konselor')
            ->get();

        return view('frontend.konselor.index', compact('konselors'));
    }

    // Menampilkan detail konselor dan memulai sesi chat
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

        // Check if user already has active session with this konselor
        $existingSession = DB::table('konsultasi_sessions')
            ->where('user_id', Auth::id())
            ->where('konselor_id', $konselor->user_id) // Fix: harus user_id konselor
            ->where('status', 'active')
            ->first();

        if (!$existingSession) {
            // Create new session
            $sessionId = DB::table('konsultasi_sessions')->insertGetId([
                'user_id' => Auth::id(),
                'konselor_id' => $konselor->user_id, // Fix: harus user_id konselor
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $sessionId = $existingSession->id;
        }

        // Get messages for this session
        $messages = DB::table('konsultasi_messages')
            ->join('users', 'konsultasi_messages.sender_id', '=', 'users.id')
            ->select('konsultasi_messages.*', 'users.name as sender_name')
            ->where('konsultasi_messages.session_id', $sessionId)
            ->orderBy('konsultasi_messages.sent_at', 'asc')
            ->get();

        return view('frontend.konselor.chat', compact('konselor', 'messages', 'sessionId'));
    }

    // Mengirim pesan ke konselor
    // Pastikan user sudah memiliki sesi aktif dengan konselor
    // Jika belum, buat sesi baru
    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:konsultasi_sessions,id',
            'message' => 'required|string|max:1000'
        ]);

        // Verify user owns this session
        $session = DB::table('konsultasi_sessions')
            ->where('id', $request->session_id)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        // Insert message
        $messageId = DB::table('konsultasi_messages')->insertGetId([
            'session_id' => $request->session_id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cek apakah ini adalah pesan pertama di sesi
        $jumlahPesanSesi = DB::table('konsultasi_messages')
            ->where('session_id', $request->session_id)
            ->count();

        if ($jumlahPesanSesi === 1) {
            // Ambil ID konselor dari sesi
            $konselorId = $session->konselor_id;

            // Kirim notifikasi ke konselor
            DB::table('notifications')->insert([
                'user_id' => $konselorId,
                'title' => 'Konsultasi Baru Dimulai',
                'message' => 'Seorang pengguna memulai sesi konsultasi dengan Anda.',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::table('konsultasi_sessions')
            ->where('id', $request->session_id)
            ->update(['updated_at' => now()]);

        // Get the inserted message with sender info
        $message = DB::table('konsultasi_messages')
            ->join('users', 'konsultasi_messages.sender_id', '=', 'users.id')
            ->select('konsultasi_messages.*', 'users.name as sender_name')
            ->where('konsultasi_messages.id', $messageId)
            ->first();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    // Mendapatkan pesan dari sesi konsultasi
    // Pastikan user memiliki sesi aktif dengan konselor
    // Jika tidak, kembalikan error 404
    public function getMessages($sessionId)
    {
        // Verify user owns this session
        $session = DB::table('konsultasi_sessions')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $messages = DB::table('konsultasi_messages')
            ->join('users', 'konsultasi_messages.sender_id', '=', 'users.id')
            ->select('konsultasi_messages.*', 'users.name as sender_name')
            ->where('konsultasi_messages.session_id', $sessionId)
            ->orderBy('konsultasi_messages.sent_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
