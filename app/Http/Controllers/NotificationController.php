<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function isRead($id, $redirect_link)
{
        // Find the notification by ID and update its 'isRead' status
        $update = Notification::where('id', $id)->update(['isRead' => true]);

        // Optionally, you can check if the update was successful
        if ($update) {
            // Redirect to the provided link if the update was successful
            return redirect()->to($redirect_link);
        } else {
            // Handle the case where the update failed
            return redirect()->back()->with('error', 'Failed to mark notification as read.');
        }
    }

    public function notificationList($filter)
    {
        if ($filter === 'unread') {
            $notifications = Notification::where('isRead', false)->get();
            return view('pages.partials.notification-list', compact('notifications'));
        }

        if ($filter === 'all') {
            $notifications = Notification::orderBy('created_at', 'DESC')->get();
            return view('pages.partials.notification-list', compact('notifications'));
        }
    
        return view('pages.partials.notification-list', ['notifications' => collect()]);
    }
    
}
