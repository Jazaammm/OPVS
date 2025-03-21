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
    return view('auth.login');
});



// Route::get('/verify-student', [AuthController::class, 'verification'])->name('verify.student');
Route::get('/verify-student', [AuthController::class,'verify'])->name('verify.student');
Route::post('/verify', [AuthController::class, 'verification'])->name('verification');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('postregister');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');

Route::get('/professor/dashboard', function () {
    return view('professor.dashboard');
})->name('professor.dashboard')->middleware('auth');

Route::get('/student/dashboard', function () {
    return view('dashboard.student');
})->name('student.dashboard')->middleware('auth');
