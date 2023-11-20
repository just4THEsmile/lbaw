<?php

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchQuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;

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
    Route::post('/updatepaylink', [UserController::class, 'updatePayLink'])->name('updatepaylink');
});


// Home
Route::redirect('/', '/login');

// Main

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/users', [HomeController::class, 'users'])->name('users');
});
Route::get('/questions', [SearchQuestionController::class, 'show'])->name('questions');
Route::get('/search/questions', [SearchQuestionController::class, 'search']);



//Edit Profile
Route::controller(ProfileController::class)->group(function () {
    Route::get('/editprofile', [ProfileController::class, 'edit'])->name('editprofile');
    Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::get('/myquestions', [ProfileController::class, 'myquestions'])->name('myquestions');
    Route::get('/myanswers', [ProfileController::class, 'myanswers'])->name('myanswers');
    Route::get('/followquestion', [ProfileController::class, 'followquestion'])->name('followquestion');
    Route::get('/users', [ProfileController::class, 'users'])->name('users');
});
Route::controller(QuestionController::class)->group(function () {
    Route::get('/createquestion', 'createform');
    Route::post('/createquestion', 'create');
    Route::get('/question/{id}', 'show');
    Route::post('/question/{id}/delete', 'delete');
    Route::get('/question/{id}/edit', 'editform');
    Route::post('/question/{id}/edit', 'edit');
});

Route::controller(AnswerController::class)->group(function () {
    Route::get('/question/{id}/answer', 'createform');
    Route::post('/question/{id}/answer', 'create');
    Route::post('/question/{id}/answer/{id_answer}/delete', 'delete');
    Route::get('/question/{id}/answer/{id_answer}/edit', 'editform');
    Route::post('/question/{id}/answer/{id_answer}/edit', 'edit');
});
/*
Route::controller(CommentController::class)->group(function () {
    Route::get('/commentable/{id}/comment', 'createform')->route('create_comment_form');
    Route::post('/commentable/{id}/comment', 'create')->route('create_comment');
    Route::post('/commentable/{id}/comment/{id_comment}/delete', 'delete')->route('delete_comment');
    Route::get('/commentable/{id}/answer/{id_comment}/edit', 'editform')->route('edit_comment_form');
    Route::post('/commentable/{id}/answer/{id_comment}/edit', 'edit')->route('edit_comment_form');
});
*/


// API
/*
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});*/


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
