<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Setting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $current_user_name = "Reinhard Esteban";
        $receiver_name = "Francis Reserva";
        $currentDate = now();
        $default = 1;

        $page_title = 'Dashboard';

        $currentCategory = Category::where('id', $default)->get();
        $transactions = Transaction::where('category_id', $default)->get();
        $categories = Category::orderBy('id')->get();
        $items = Item::where('category_id', $default)->get();

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



        // Extract days with records
        $daysWithRecords = $transactions->map(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->rent_date)->format('Y-m-d');
        })->unique()->values()->toArray();

        $setting = Setting::findOrFail(1);

        return view('pages.dashboard', compact('setting', 'current_user_name', 'receiver_name', 'contacts', 'unreadMessages', 'page_title', 'unreadNotifications', 'notifications', 'items', 'currentCategory', 'categories', 'currentDate', 'transactions', 'daysWithRecords'));
    }

    public function dateView($date)
    {

        $transactions = Transaction::where('rent_date', $date)->get();
        $date = $date;

        $setting = Setting::findOrFail(1);

        return view('pages.partials.date-view', compact('setting', 'transactions', 'date'));
    }

    public function dateCustom(Request $request)
    {

        $page_title = "Dashboard";
        $current_user_name = "Reinhard Esteban";

        // Get year and month from request
        $year = $request->year;
        $month = $request->month;
        $category = $request->category;

        // Construct the date string and create a Carbon instance for the first day of the s            cified month and year
        $currentDate = now()->setDate($year, $month, 25);

        $transactions = Transaction::where('category_id', $category)->get();

        $categories = Category::orderBy('id')->get();
        $currentCategory = Category::where('id', $category)->get();

        $notifications = Notification::orderBy('created_at', 'DESC')->get();
        $unreadNotifications = Notification::where('isRead', false)->get()->count();

        $messages = Message::where('receiver_name', $current_user_name)->where('isRead', false)->get();
        $unreadMessages = $messages->count();


        $daysWithRecords = $transactions->map(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->rent_date)->format('Y-m-d');
        })->unique()->values()->toArray();

        $items = Item::where('category_id', $category)->get();

        $contacts = Message::where('receiver_name', $current_user_name)
            ->latest()
            ->get()
            ->groupBy('sender_name')
            ->map(function ($group) {
                return $group->first();
            })
            ->values();

        $setting = Setting::findOrFail(1);

        return view('pages.dashboard', compact('setting', 'contacts', 'unreadMessages', 'page_title', 'notifications', 'unreadNotifications', 'items', 'currentCategory', 'categories', 'currentDate', 'transactions', 'daysWithRecords'));
    }

    public function transactionAdd(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'item_id' => 'required',
            'category_id' => 'required',
            'rentee_name' => 'required|string|max:255',
            'rentee_contact_no' => 'required|string|max:255',
            'rentee_email' => 'required|string|email|max:255',
            'rent_date' => 'required|date',
            'rent_time' => 'required|date_format:H:i', // Assuming time format is HH:MM
            'rent_return' => 'required|date',
            'rent_return_time' => 'required|date_format:H:i', // Assuming time format is HH:MM
        ]);

        // Create a new transaction
        try {
            $transaction = Transaction::create([
                'item_id' => $validatedData['item_id'],
                'category_id' => $validatedData['category_id'],
                'rentee_name' => $validatedData['rentee_name'],
                'rentee_contact_no' => $validatedData['rentee_contact_no'],
                'rentee_email' => $validatedData['rentee_email'],
                'rent_date' => $validatedData['rent_date'],
                'rent_time' => $validatedData['rent_time'],
                'rent_return' => $validatedData['rent_return'],
                'rent_return_time' => $validatedData['rent_return_time'],
                'status' => 'pending',
            ]);

            $notification = Notification::create([
                'icon' => "https://cdn-icons-png.flaticon.com/512/9187/9187604.png",
                'title' => "New Transaction",
                'description' => "Reinhard Esteban added a new transaction, check it now.",
                'redirect_link' => "transactions"
            ]);


            // Flash a success message to the session
            return redirect()->back()->with('success', 'Transaction created successfully.');

        } catch (\Exception $e) {
            // Flash an error message to the session
            return redirect()->back()->with('error', 'Error creating transaction: ' . $e->getMessage());
        }
    }

    public function calendarMove($action, $category, $year, $month)
    {
        // Get year and month from request

        $page_title = 'Dashboard';
        $current_user_name = 'Reinhard Esteban';

        $contacts = Message::where('receiver_name', $current_user_name)
            ->latest()
            ->get()
            ->groupBy('sender_name')
            ->map(function ($group) {
                return $group->first();
            })
            ->values();


        // Handle the action (e.g., next month, previous month)
        if ($action === 'left') {


            $category = $category;

            $currentDate = now()->setDate($year, $month - 1, 1);

            $transactions = Transaction::where('category_id', $category)->get();

            $categories = Category::orderBy('id')->get();
            $currentCategory = Category::where('id', $category)->get();

            $notifications = Notification::orderBy('created_at', 'DESC')->get();
            $unreadNotifications = Notification::where('isRead', false)->get()->count();

            $messages = Message::where('receiver_name', $current_user_name)->where('isRead', false)->get();
            $unreadMessages = $messages->count();





            $daysWithRecords = $transactions->map(function ($transaction) {
                return \Carbon\Carbon::parse($transaction->rent_date)->format('Y-m-d');
            })->unique()->values()->toArray();

            $items = Item::where('category_id', $category)->get();

            $setting = Setting::findOrFail(1);

            return view('pages.dashboard', compact('setting', 'contacts', 'current_user_name', 'unreadMessages', 'page_title', 'notifications', 'unreadNotifications', 'items', 'currentCategory', 'categories', 'currentDate', 'transactions', 'daysWithRecords'));


        } elseif ($action === 'right') {
            $category = $category;

            $currentDate = now()->setDate($year, $month + 1, 1);

            $transactions = Transaction::where('category_id', $category)->get();

            $categories = Category::orderBy('id')->get();
            $currentCategory = Category::where('id', $category)->get();

            $notifications = Notification::orderBy('created_at', 'DESC')->get();
            $unreadNotifications = Notification::where('isRead', false)->get()->count();


            $messages = Message::where('receiver_name', $current_user_name)->where('isRead', false)->get();
            $unreadMessages = $messages->count();


            $daysWithRecords = $transactions->map(function ($transaction) {
                return \Carbon\Carbon::parse($transaction->rent_date)->format('Y-m-d');
            })->unique()->values()->toArray();

            $items = Item::where('category_id', $category)->get();

            $setting = Setting::findOrFail(1);

            return view('pages.dashboard', compact('setting', 'contacts', 'current_user_name', 'unreadMessages', 'page_title', 'notifications', 'unreadNotifications', 'items', 'currentCategory', 'categories', 'currentDate', 'transactions', 'daysWithRecords'));



        } elseif ($action === 'today') {
            $category = $category;

            $currentDate = now();

            $transactions = Transaction::where('category_id', $category)->get();

            $categories = Category::orderBy('id')->get();
            $currentCategory = Category::where('id', $category)->get();

            $notifications = Notification::orderBy('created_at', 'DESC')->get();
            $unreadNotifications = Notification::where('isRead', false)->get()->count();

            $messages = Message::where('receiver_name', $current_user_name)->where('isRead', false)->get();
            $unreadMessages = $messages->count();


            $daysWithRecords = $transactions->map(function ($transaction) {
                return \Carbon\Carbon::parse($transaction->rent_date)->format('Y-m-d');
            })->unique()->values()->toArray();

            $items = Item::where('category_id', $category)->get();

            $setting = Setting::findOrFail(1);

            return view('pages.dashboard', compact('setting', 'contacts', 'current_user_name', 'unreadMessages', 'page_title', 'notifications', 'unreadNotifications', 'items', 'currentCategory', 'categories', 'currentDate', 'transactions', 'daysWithRecords'));

        }



    }

}
