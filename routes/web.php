<?php

use App\Http\Controllers\MainTaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['auth']], function(){
    Route::get('mainTask', [MainTaskController::class, 'index'])->name('mainTask.index');
    Route::post('mainTask/{id}', [MainTaskController::class, 'store'])->name('mainTask.store');
    Route::put('mainTask/{id}', [MainTaskController::class, 'update'])->name('mainTask.update');
    Route::delete('mainTask/{id}', [MainTaskController::class, 'delete'])->name('mainTask.delete');
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

require __DIR__.'/auth.php';
