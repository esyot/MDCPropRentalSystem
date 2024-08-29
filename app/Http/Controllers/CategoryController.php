<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $current_user_name = "Reinhard Esteban";

        $categories = Category::all();

        $default = 1;

        $page_title = "Categories";

        $setting = Setting::findOrFail(1);

        $notifications = Notification::orderBy('created_at', 'DESC')->get();
        $unreadNotifications = Notification::where('isRead', false)->get()->count();

        $messages = Message::where('receiver_name', $current_user_name)->where('isRead', false)->get();
        $unreadMessages = $messages->count();

        $contacts = Message::where('receiver_name', $current_user_name)
            ->latest()
            ->get()
            ->groupBy('sender_name')
            ->map(function ($group) {
                return $group->first();
            })
            ->values();

        $currentCategory = Category::where('id', $default)->get();

        return view('pages.category', compact('currentCategory', 'contacts', 'unreadMessages', 'notifications', 'unreadNotifications', 'page_title', 'setting', 'categories'));

    }
}
