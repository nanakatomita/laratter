<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Tweet;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // バリデーション済みのテキストデータを更新
    $user->fill($request->validated());
 
    $user->bio = $request->input('bio');

    // アイコン画像のアップロード
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    // ヘッダー画像
    if ($request->hasFile('header_image')) {
        $path = $request->file('header_image')->store('headers', 'public');
        $user->header_image = $path;
    }

    // メール
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function show(User $user)
  {
    if (auth()->user()->is($user)) {
      $tweets = Tweet::query()
        ->where('user_id', $user->id)  // 自分のツイート
        ->orWhereIn('user_id', $user->follows->pluck('id')) // フォローしているユーザーのツイート
        ->latest()
        ->paginate(10);
    } else {
      // 他のユーザーの場合、そのユーザーのツイートのみを取得
      $tweets = $user
        ->tweets()
        ->latest()
        ->paginate(10);
    }

    // ユーザーのフォロワーとフォローしているユーザーを取得
    $user->load(['follows', 'followers']);

    return view('profile.show', compact('user', 'tweets'));
  }
}
