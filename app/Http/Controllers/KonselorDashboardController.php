<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonselorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan hanya role 4 (konselor)
        if ($user->role != 4) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Cek apakah user sudah menjadi konselor
        $konselor = DB::table('konselors')
            ->where('user_id', $user->id)
            ->where('is_delete', 0)
            ->first();

        // Jika belum jadi konselor, tampilkan halaman info
        if (!$konselor) {
            return view('admin.chat.not-registered');
        }

        // Ambil sesi jika sudah jadi konselor
        $sessions = DB::table('konsultasi_sessions')
            ->join('users', 'konsultasi_sessions.user_id', '=', 'users.id')
            ->leftJoin('konsultasi_messages', function ($join) {
                $join->on('konsultasi_sessions.id', '=', 'konsultasi_messages.session_id')
                    ->whereRaw('konsultasi_messages.id = (
                     SELECT MAX(id) FROM konsultasi_messages
                     WHERE session_id = konsultasi_sessions.id
                 )');
            })
            ->select(
                'konsultasi_sessions.*',
                'users.name as user_name',
                'users.image as user_image',
                'konsultasi_messages.message as last_message',
                'konsultasi_messages.sent_at as last_message_time'
            )
            ->where('konsultasi_sessions.konselor_id', $user->id)
            ->where('konsultasi_sessions.status', 'active')
            ->orderBy('konsultasi_sessions.updated_at', 'desc')
            ->get();

        return view('admin.chat.index', compact('konselor', 'sessions'));
    }


    public function chat($sessionId)
    {
        // Verify konselor owns this session
        $session = DB::table('konsultasi_sessions')
            ->join('users', 'konsultasi_sessions.user_id', '=', 'users.id')
            ->select(
                'konsultasi_sessions.*',
                'users.name as user_name',
                'users.image as user_image'
            )
            ->where('konsultasi_sessions.id', $sessionId)
            ->where('konsultasi_sessions.konselor_id', Auth::id())
            ->where('konsultasi_sessions.status', 'active')
            ->first();

        if (!$session) {
            abort(404, 'Sesi tidak ditemukan');
        }

        // Get messages for this session
        $messages = DB::table('konsultasi_messages')
            ->join('users', 'konsultasi_messages.sender_id', '=', 'users.id')
            ->select('konsultasi_messages.*', 'users.name as sender_name')
            ->where('konsultasi_messages.session_id', $sessionId)
            ->orderBy('konsultasi_messages.sent_at', 'asc')
            ->get();

        return view('admin.chat.chat', compact('session', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:konsultasi_sessions,id',
            'message' => 'required|string|max:1000'
        ]);

        // Verify konselor owns this session
        $session = DB::table('konsultasi_sessions')
            ->where('id', $request->session_id)
            ->where('konselor_id', Auth::id())
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

        // Update session timestamp
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

    public function getMessages($sessionId)
    {
        // Verify konselor owns this session
        $session = DB::table('konsultasi_sessions')
            ->where('id', $sessionId)
            ->where('konselor_id', Auth::id())
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
