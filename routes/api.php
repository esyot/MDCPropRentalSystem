<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('date-view/{date}', [DashboardController::class, 'dateView'])->name('dateView');
Route::get('date-custom', [DashboardController::class, 'dateCustom'])->name('dateCustom');

Route::post('transaction-create', [DashboardController::class, 'transactionAdd'])->name('transaction-create');

Route::get('isRead/{id}/{redirect_link}', [NotificationController::class, 'isRead'])->name('isRead');

Route::get('transaction-decline/{id}', [TransactionController::class, 'decline'])->name('transactionDecline');

Route::get('notification/read/all', [NotificationController::class, 'readAll'])->name('readAll');

Route::get('notification/delete/all', [NotificationController::class, 'deleteAll'])->name('deleteAll');

Route::get('message-is-reacted/{id}', [MessageController::class, 'messageReacted'])->name('messageReacted');

Route::post('message-send', [MessageController::class, 'messageSend'])->name('messageSend');

Route::get('contacts', [MessageController::class, 'contacts'])->name('contacts');