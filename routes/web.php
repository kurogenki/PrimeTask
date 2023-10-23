<?php

use App\Http\Controllers\MainTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LineLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group(['middleware' => ['auth']], function(){
    Route::resource('mainTask', MainTaskController::class);
    Route::get('finishMainTask/{id}', [MainTaskController::class, 'finishMainTask'])->name('finishMainTask');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// LINEログイン
// Route::get('/linelogin', 'LineLoginController@lineLogin')->name('linelogin');
// Route::get('/callback', 'LineLoginController@callback')->name('callback');
Route::get('/linelogin', [LineLoginController::class, 'lineLogin'])->name('linelogin');
Route::get('/callback', [LineLoginController::class, 'callback'])->name('linelogin');

require __DIR__.'/auth.php';
