<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">プロフィール編集</h1>

                {{-- 更新成功メッセージ --}}
                @if(session('status') === 'profile-updated')
                    <div class="mb-4 p-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                        プロフィールを更新しました！
                    </div>
                @endif

                {{-- バリデーションエラー --}}
                @if($errors->any())
                    <div class="mb-4 p-2 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    {{-- 名前 --}}
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300">名前</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    {{-- メール --}}
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    {{-- 自己紹介 --}}
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300">自己紹介</label>
                        <textarea name="bio" rows="4"
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    {{-- アイコン --}}
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300">アイコン画像</label>
                        <input type="file" name="avatar" class="mt-1 block">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" width="100"
                                 class="mt-2  border border-gray-300 dark:border-gray-600">
                        @endif
                    </div>

                    {{-- ヘッダー --}}
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300">ヘッダー画像</label>
                        <input type="file" name="header_image" class="mt-1 block">
                        @if($user->header_image)
                            <img src="{{ asset('storage/' . $user->header_image) }}" alt="header" width="300"
                                 class="mt-2 rounded border border-gray-300 dark:border-gray-600">
                        @endif
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md">
                        更新
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
