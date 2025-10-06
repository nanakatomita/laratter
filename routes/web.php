<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\TweetBookmarkController;
use App\Http\Controllers\BookmarkController;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  // 🔽 検索のルーティングを追加
  Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
  Route::get('/tweets/search', [TweetController::class, 'search'])->name('tweets.search');
  Route::resource('tweets', TweetController::class);
  Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])->name('tweets.like');
  Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])->name('tweets.dislike');
  Route::resource('tweets.comments', CommentController::class);
  Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
  Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
  Route::post('/tweets/{tweet}/bookmark', [TweetBookmarkController::class, 'store'])->name('tweets.bookmark');
Route::delete('/tweets/{tweet}/bookmark', [TweetBookmarkController::class, 'destroy'])->name('tweets.unbookmark');
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');



});

require __DIR__ . '/auth.php';