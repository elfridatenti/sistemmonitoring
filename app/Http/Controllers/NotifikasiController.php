<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use App\Events\NewNotification;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function notifikasi()
    {
        // Ambil semua notifikasi yang belum dibaca untuk user yang sedang login
        $notifications = Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
   
        return view('partials.notifikasi', compact('notifications'));
    }

    public function markAsRead($id)
{
    $notification = Notifikasi::find($id);
    
    if ($notification && $notification->user_id == Auth::id()) {
        // Decode data JSON untuk mendapatkan redirect URL
        $data = json_decode($notification->data, true);
        $redirectUrl = $data['redirect_url'] ?? '/';
        
        // Hapus notifikasi
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Notification not found'
    ], 404);
}

    public function getUnreadCount()
    {
        $count = Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }

    public function triggerNotification($userId, $title, $message, $redirectUrl = '/')
    {
        // Tentukan redirect URL berdasarkan tipe notifikasi
        $redirectUrl = match(true) {
            stripos($message, 'downtime') !== false || stripos($title, 'downtime') !== false => '/downtime',
            stripos($message, 'setup') !== false || stripos($title, 'setup') !== false => '/setup',
            stripos($message, 'qc approve setup') !== false => '/qc/setup',
            stripos($message, 'qc approve downtime') !== false => '/qc/downtime',
            default => $redirectUrl
        };

        $user = User::findOrFail($userId);
   
        $notification = Notifikasi::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
            'data' => json_encode([
                'message' => $message,
                'redirect_url' => $redirectUrl,
                'type' => $this->determineNotificationType($title, $message)
            ])
        ]);

        broadcast(new NewNotification($notification))->toOthers();
        
        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }

    private function determineNotificationType($title, $message)
    {
        $title = strtolower($title);
        $message = strtolower($message);
        
        if (str_contains($title, 'downtime') || str_contains($message, 'downtime')) {
            return 'downtime';
        } elseif (str_contains($title, 'setup') || str_contains($message, 'setup')) {
            return 'setup';
        } elseif (str_contains($message, 'qc approve setup')) {
            return 'qc_setup';
        } elseif (str_contains($message, 'qc approve downtime')) {
            return 'qc_downtime';
        }
        
        return 'default';
    }
}