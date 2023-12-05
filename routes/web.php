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
use App\Http\Controllers\FileController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationController;
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
    Route::post('/updateuser', [UserController::class, 'updateUser'])->name('updateuser');
    Route::post('/user/{id}/delete', 'deleteAccount')->name('deleteaccount');
    Route::post('/updateuseradmin', [UserController::class, 'updateUserAdmin'])->name('updateuseradmin');
});

Route::post('/file/upload', [FileController::class, 'upload']);


// Home
Route::redirect('/', '/login');

// Main

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/faq',[HomeController::class,'faq']);
});

// Search
Route::controller(SearchQuestionController::class)->group(function () {
    Route::get('/questions',  'show')->name('questions');
    Route::get('/questions/tag/{id}',  'show_with_tags')->name('questionswithtags');
});

Route::controller(UsersController::class)->group(function () {
    Route::get('/users',  'getUsers')->name('users');
    Route::get('/search/users','search');
});
//Edit Profile
Route::controller(ProfileController::class)->group(function () {
    Route::get('/editprofile/{id}', [ProfileController::class, 'edit'])->name('editprofile');
    Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::get('/myquestions/{id}', [ProfileController::class, 'myquestions'])->name('myquestions');
    Route::get('/myanswers/{id}', [ProfileController::class, 'myanswers'])->name('myanswers');
    Route::get('/followquestion/{id}', [ProfileController::class, 'followedQuestions'])->name('followquestion');
    Route::get('/myblocked/{id}', [ProfileController::class, 'myblocked'])->name('myblocked');
});

Route::controller(QuestionController::class)->group(function () {
    Route::get('/createquestion', 'createform');
    Route::post('/createquestion', 'create');
    Route::get('/question/{id}', 'show')->name("question.show");
    Route::post('/question/{id}/delete', 'delete');
    Route::get('/question/{id}/edit', 'editform');
    Route::post('/question/{id}/edit', 'edit');
    Route::post('/question/{id}/followquestion', 'follow');
});

Route::controller(AnswerController::class)->group(function () {
    Route::get('/question/{id}/answer', 'createform');
    Route::post('/question/{id}/answer', 'create');
    Route::post('/question/{id}/answer/{id_answer}/delete', 'delete');
    Route::get('/question/{id}/answer/{id_answer}/edit', 'editform');
    Route::post('/question/{id}/answer/{id_answer}/edit', 'edit');
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/commentable/{id}/comment', 'createform')->name('create_comment_form');
    Route::post('/commentable/{id}/comment', 'create')->name('create_comment');
    Route::post('/commentable/{id}/comment/{comment_id}/delete', 'delete')->name('delete_comment');
    Route::get('/commentable/{id}/answer/{comment_id}/edit', 'editform')->name('edit_comment_form');
    Route::post('/commentable/{id}/answer/{comment_id}/edit', 'edit')->name('edit_comment');
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/forgot', 'ForgotPassword')->name('forgot');
    Route::post('/password', 'ResetPasswordMail')->name('password');
    Route::get('/reset/{token}', 'ResetForm')->name('reset');
    Route::post('/resetpassword', 'ResetPassword')->name('resetpassword');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(ContentController::class)->group(function () {
    Route::post('/report/{content_id}', 'reportContent')->name('report');
    Route::get('/api/unblockrequest/{id}','unblockrequest')->name('unblockrequest');
    Route::post('sendunblock', 'sendunblock')->name('sendunblock');
});

Route::controller(TagController::class)->group(function () {
    Route::get('/tag/{id}', 'tagquestionspage')->name('tagquestions');
    Route::get('/search/tag/', 'search')->name('tagsearch');
    Route::get('/tags', 'tagspage')->name('tags');
    Route::get('/question/{id}/tags', 'getTagsOfQuestion')->name('getTagsOfQuestion'); //api
});
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications', 'getnotifications')->name('notifications_page');
});

//api
Route::post('/api/correct/{questionid}', [QuestionController::class, 'correctanswer']);
Route::post('/api/vote/{id}', [ContentController::class, 'voteContent']);
Route::get('/api/tag/{id}/questions', [TagController::class ,'tagquestions'])->name('tagquestionsapi');
Route::get('/api/search/questions',  [SearchQuestionController::class,'search']);
Route::get('/api/myquestions/{id}', [ProfileController::class, 'listmyquestions']);
Route::get('/api/myanswers/{id}', [ProfileController::class, 'listmyanswers']);
Route::get('/api/followedQuestions/{id}', [ProfileController::class, 'listfollowedquestions']);
Route::get('/api/search/tag/', [TagController::class,'search']); // search for all tags
Route::get('/api/fullsearch/tag/', [TagController::class,'searchWithoutLimits']);
Route::get('/api/question/{id}/tags', [TagController::class,'getTagsOfQuestion']);
Route::get('/api/myblocked/{id}',  [ProfileController::class,'listmyblocked']);


Route::get('/moderatecontent', [ContentController::class, 'moderatecontent'])->name('moderatecontent');
Route::get('/reviewcontent/{id}', [ContentController::class, 'reviewcontent'])->name('reviewcontent');
Route::post('/processRequest', [ContentController::class, 'processRequest'])->name('processRequest');


