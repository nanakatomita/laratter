<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('ブックマーク一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <!-- ページネーション -->
          <div class="mb-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>

          @forelse ($tweets as $tweet)
            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">

              <!-- 🔽 アイコン + ユーザー名 -->
              <div class="flex items-center mb-2">
                @if ($tweet->user->avatar)
                  <img src="{{ asset('storage/' . $tweet->user->avatar) }}"
                       alt="User Icon"
                       class="w-10 h-10 object-cover mr-2 ">
                @else
                  <div class="w-10 h-10 bg-gray-400 flex items-center justify-center mr-2">
                    <span class="text-xs text-white"></span>
                  </div>
                @endif
                <a href="{{ route('profile.show', $tweet->user) }}">
                  <p class="text-gray-600 dark:text-gray-400 text-sm">
                    投稿者: {{ $tweet->user->name }}
                  </p>
                </a>
              </div>

              <p class="text-gray-800 dark:text-gray-300">{{ $tweet->tweet }}</p>
              <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>

              {{-- 🔽 いいねボタン --}}
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

              {{-- 🔽 ブックマークボタン --}}
              <div class="flex mt-2">
                @if ($tweet->bookmarked->contains(auth()->id()))
                  <form action="{{ route('tweets.unbookmark', $tweet) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                      ブックマーク解除 {{ $tweet->bookmarked->count() }}
                    </button>
                  </form>
                @else
                  <form action="{{ route('tweets.bookmark', $tweet) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                      ブックマーク {{ $tweet->bookmarked->count() }}
                    </button>
                  </form>
                @endif
              </div>
              {{-- 🔼 ここまで --}}
            </div>
          @empty
            <p class="text-gray-500 dark:text-gray-400">ブックマークした投稿はまだありません。</p>
          @endforelse

          <!-- ページネーション -->
          <div class="mt-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
