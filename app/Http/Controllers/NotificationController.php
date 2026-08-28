<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** Liste complète (paginée) — page "Toutes mes notifications". */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return view('partials.notifications-index', compact('notifications'));
    }

    public function marquerLue(Request $request, string $notification)
    {
        $notif = auth()->user()->notifications()->findOrFail($notification);
        $notif->markAsRead();

        if ($notif->data['url'] ?? null) {
            return redirect($notif->data['url']);
        }

        return back();
    }

    public function marquerToutesLues()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Notifications marquées comme lues.');
    }
}
