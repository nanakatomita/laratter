<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('User詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- ヘッダー画像 --}}
<div class="w-full overflow-hidden rounded-t-lg">
    @if($user->header_image)
        <img src="{{ asset('storage/' . $user->header_image) }}" 
             alt="Header" 
             class="w-full h-[500px] object-cover">
    @else
        <div class="w-full h-[500px] bg-gray-300 dark:bg-gray-700"></div>
    @endif
</div>



      {{-- ユーザー情報 --}}
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center space-x-4">
        {{-- アイコン --}}
        @if($user->avatar)
          <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
               class="w-16 h-16  border-2 border-white dark:border-gray-800 object-cover">
        @else
          <div class="w-16 h-16 l bg-gray-400 border-2 border-white dark:border-gray-800"></div>
        @endif

        {{-- 名前・自己紹介 --}}
        <div>
          <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
          @if($user->bio)
            <p class="text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
          @endif
          <p class="text-gray-500 dark:text-gray-400 text-sm">
            アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}
          </p>
        </div>
      </div>

          {{-- フォロー/アンフォロー --}}
          @if ($user->id !== auth()->id())
            <div class="mt-2">
              @if ($user->followers->contains(auth()->id()))
                <form action="{{ route('follow.destroy', $user) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-500 hover:text-red-700">Unfollow</button>
                </form>
              @else
                <form action="{{ route('follow.store', $user) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-blue-500 hover:text-blue-700">Follow</button>
                </form>
              @endif
            </div>
          @endif

          {{-- フォロー数・フォロワー数 --}}
          <div class="mt-2 text-gray-600 dark:text-gray-400">
            <span>following: {{$user->follows->count()}}</span> |
            <span>followers: {{$user->followers->count()}}</span>
          </div>

          {{-- ツイート表示 --}}
          @if ($tweets->count())
            <!-- ページネーション 上 -->
            <div class="mb-4 mt-4">
              {{ $tweets->appends(request()->input())->links() }}
            </div>

            @foreach ($tweets as $tweet)
              <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <p class="text-gray-800 dark:text-gray-300">{{ $tweet->tweet }}</p>
                <a href="{{ route('profile.show', $tweet->user) }}">
                  <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $tweet->user->name }}</p>
                </a>
                <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                <div class="flex mt-2">
                  @if ($tweet->liked->contains(auth()->id()))
                    <form action="{{ route('tweets.dislike', $tweet) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-500 hover:text-red-700">
                        dislike {{ $tweet->liked->count() }}
                      </button>
                    </form>
                  @else
                    <form action="{{ route('tweets.like', $tweet) }}" method="POST">
                      @csrf
                      <button type="submit" class="text-blue-500 hover:text-blue-700">
                        like {{ $tweet->liked->count() }}
                      </button>
                    </form>
                  @endif
                </div>
              </div>
            @endforeach

            <!-- ページネーション 下 -->
            <div class="mt-4">
              {{ $tweets->appends(request()->input())->links() }}
            </div>

          @else
            <p class="mt-4 text-gray-600 dark:text-gray-400">No tweets found.</p>
          @endif

        </div>
      </div>

    </div>
  </div>
</x-app-layout>
