<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThreadController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'show'])->name('home');

Route::get('/dashboard', function(){
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/thread/{thread_id}', [ThreadController::class, 'show'])->name('thread.show');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/thread/submit', [ThreadController::class, 'store'])->name('thread.submit');
    Route::post('/comment/submit', [CommentController::class, 'store'])->name('comment.submit');
    Route::get('/like/thread/{thread}', [ThreadController::class, 'like'])->name('like');
    Route::get('/like/comment/{comment}', [CommentController::class, 'like'])->name('comment.like');
});

// Route::middleware(['auth:sanctum'])->post('/thread/submit', [ThreadController::class, 'store'])->name('thread.submit');

// Route::middleware(['auth:sanctum'])->get('/like/{thread}', [ThreadController::class, 'like'])->name('like');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');
