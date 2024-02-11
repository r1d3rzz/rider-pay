<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//For Admin Users
Route::prefix('admin')->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('login', 'create')->name('admin.login');
        Route::post('login', 'store')->name('admin.login');
        Route::post('logout', 'destroy')->name('admin.logout');
    });

    Route::get('/', function () {
        return 'admin';
    })->name('admin.home');
});

//For Users
Route::middleware('auth')->group(function () {
    Route::get("/", [PageController::class, 'home']);
});


require __DIR__ . '/auth.php';
