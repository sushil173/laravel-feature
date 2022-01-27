<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('invite-user', [AuthController::class, 'registration'])->name('invite-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

// user extra registration
Route::post('user-registration', [AuthController::class, 'userRegistration'])->name('register.user');
Route::get('userotp', [AuthController::class, 'userOtp'])->name('user.otp');
Route::post('postuserotp', [AuthController::class, 'postUserOtp'])->name('user.post.otp');

Route::get('verify/{email}/{otp}/{id}', [AuthController::class, 'verifyUrl'])->name('verification.address');