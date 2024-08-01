<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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
Route::match(['get', 'post'], '/', [MainController::class, 'introduction'])->name('/');
// Route::match(['get', 'post'], '/', [MainController::class, 'login_signup'])->name('/');
Route::match(['get', 'post'], 'login', [MainController::class, 'login'])->name('login');
Route::match(['get', 'post'], 'signup', [MainController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], 'logout', [MainController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], 'login_signup', [MainController::class, 'login_signup'])->name('login_signup');


// Routes accessible only to authenticated users
Route::middleware(['auth'])->group(function () {
    // Route::match(['get', 'post'], 'introduction', [MainController::class, 'introduction'])->name('introduction');
    Route::match(['get', 'post'], 'dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], 'add-new-book', [MainController::class, 'add_new_book'])->name('add-new-book');
    Route::match(['get', 'post'], 'view', [MainController::class, 'view'])->name('view');
    Route::match(['get', 'post'], 'save-book', [MainController::class, 'save_book'])->name('save-book');
    Route::match(['get', 'post'], 'delete', [MainController::class, 'delete'])->name('delete');
    Route::match(['get', 'post'], 'save-audio', [MainController::class, 'save_audio'])->name('save-audio');
});

Route::match(['get', 'post'], 'share', [MainController::class, 'share'])->name('share');


// just for example
Route::match(['get', 'post'], 'naveed', [MainController::class, 'naveed'])->name('naveed');
