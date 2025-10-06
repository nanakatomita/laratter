<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 自分がブックマークしたツイートを取得
        $tweets = $user->bookmarks()->with(['user', 'liked', 'bookmarked'])->latest()->paginate(10);

        return view('bookmarks.index', compact('tweets'));
    }
}