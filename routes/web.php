<?php
use App\Http\Controllers\SmoothieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SmoothieController::class, 'index']);

Route::group(['middleware' => ['auth', 'role:admin']], function () {
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::group(['middleware' => 'auth'], function () {
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware(['verified']);
Route::get('/profile/smoothies', [UserController::class, 'userSmoothies'])->name('profile.smoothies');
Route::post('/profile/smoothies/toggle-status/{smoothie}', [UserController::class, 'toggleSmoothieStatus'])->name('profile.smoothies.toggle-status');
Route::get('/profile/smoothies/edit/{smoothie}', [UserController::class, 'editSmoothie'])->name('profile.smoothies.edit');
Route::put('/profile/smoothies/update/{smoothie}', [UserController::class, 'updateSmoothie'])->name('profile.smoothies.update');
Route::delete('/profile/smoothies/delete/{smoothie}', [UserController::class, 'deleteSmoothie'])->name('profile.smoothies.delete');
});

// Resourceful route for SmoothieController
Route::resource('smoothies', SmoothieController::class)->parameters(['smoothies' => 'smoothie']);

Route::get('/smoothies/{smoothie}', [SmoothieController::class, 'show'])->name('smoothies.show');

Auth::routes(['verify' => true]);

// User profile route
Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile')->middleware(['auth', 'verified']);

Route::put('/profile/update', 'UserController@updateProfile')->name('profile.update');




Route::post('/smoothies/{smoothie}/toggle', [SmoothieController::class, 'toggle'])->name('smoothies.toggle');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');



Route::get('/test', function () {
    return view('test');
})->name('test');
