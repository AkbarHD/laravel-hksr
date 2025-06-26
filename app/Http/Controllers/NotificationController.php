<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getNotifikasi()
    {
        $user = Auth::user();

        // Ambil notifikasi terbaru milik user ini (limit 10, bisa disesuaikan)
        $notifications = DB::table('notifications')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Hitung yang belum dibaca (is_read = 0 atau false)
        $jumlah = DB::table('notifications')
            ->where('user_id', $user->id)
            ->where('is_read', 0) // atau false, tergantung tipe data
            ->count();

        $html = '';

        // Buat HTML untuk daftar notifikasi
        foreach ($notifications as $notif) {
            $createdAt = Carbon::parse($notif->created_at)->diffForHumans();
            $html .= '
                <a href="#" class="list-group-item' . ($notif->is_read ? '' : ' fw-bold') . '">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>' . $notif->title . '</strong><br>
                            <small>' . $notif->message . '</small>
                        </div>
                        <small class="text-muted">' . $createdAt . '</small>
                    </div>
                </a>';
        }

        return response()->json([
            'jumlah' => $jumlah,
            'html' => $html
        ]);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAsRead()
    {
        $updated = DB::table('notifications')
            ->where('user_id', Auth::id())
            ->where('is_read', 0) // atau false
            ->update(['is_read' => 1]); // 1 itu berarti sudah dibaca

        return response()->json([
            'success' => true,
            'updated' => $updated
        ]);
    }
}
