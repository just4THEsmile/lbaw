<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

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

//User
Route::controller(UserController::class)->group(function () {
    Route::post('/updatename', [UserController::class, 'updateName'])->name('updatename'); 
    Route::post('/updateusername', [UserController::class, 'updateUsername'])->name('updateusername');
    Route::post('/updatemail', [UserController::class, 'updateEmail'])->name('updatemail');
    Route::post('/updatepassword', [UserController::class, 'updatePassword'])->name('updatepassword');  
    Route::post('/updatebio', [UserController::class, 'updateBio'])->name('updatebio');
    Route::post('/updateprofilepicture', [UserController::class, 'updateProfilePicture'])->name('updateprofilepicture');
});


// Home
Route::redirect('/', '/login');

// Main

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


//Edit Profile
Route::controller(ProfileController::class)->group(function () {
    Route::get('/editprofile', [ProfileController::class, 'edit'])->name('editprofile');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});
Route::controller(QuestionController::class)->group(function () {
    Route::get('/question/{id}', 'show');
});

// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});
