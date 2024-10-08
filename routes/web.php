<?php

use App\Http\Controllers\MainTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\LineMessengerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function Termwind\render;

Route::group(['middleware' => ['auth']], function(){
    Route::get('mainTask', [MainTaskController::class, 'index'])->name('mainTask');
    Route::resource('mainTask', MainTaskController::class);
    Route::get('finishMainTask/{id}', [MainTaskController::class, 'finishMainTask'])->name('finishMainTask');
});
Route::get('/logOut/{id}', [ProfileController::class, 'logOut']);

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});



// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// LINEログイン
Route::get('/line-login', [LineLoginController::class, 'lineLogin'])->name('lineLogin');
Route::get('/callback', [LineLoginController::class, 'callback'])->name('callback');

// LINE メッセージ受信
Route::post('/line/webhook', [LineMessengerController::class, 'webhook'])->name('line.webhook');

// LINE メッセージ送信用
Route::get('/line/message', [LineMessengerController::class, 'message']);

require __DIR__.'/auth.php';
