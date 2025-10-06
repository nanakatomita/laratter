<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetBookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Tweet $tweet)
{
    $tweet->bookmarked()->attach(auth()->id());
    return back();
}

public function destroy(Tweet $tweet)
{
    $tweet->bookmarked()->detach(auth()->id());
    return back();
}

}
