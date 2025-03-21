<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('verify');
});



// Route::get('/verify-student', [AuthController::class, 'verification'])->name('verify.student');
Route::get('/verify-student', [AuthController::class,'verify'])->name('verify.student');
Route::post('/verify', [AuthController::class, 'verification'])->name('verification');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('postregister');

