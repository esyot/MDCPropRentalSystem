<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index(){

        $transactions = Transaction::where('category_id', 1)->get();

        $unreadNotifications = Notification::where('isRead', false)->get()->count();
        $notifications = Notification::orderBy('created_at', 'DESC')->get();

        $categories = Category::all();
        $currentCategory = Category::where('id', 1)->get();

        $page_title = 'Pending Transactions';

        return view('pages.transactions', compact('page_title', 'currentCategory', 'categories', 'transactions', 'unreadNotifications', 'notifications'));

    }

    public function decline($id){

        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        if($transaction){

            return redirect()->back()->with('success', 'Transaction has been successfully declined!');
        }


    }
}
