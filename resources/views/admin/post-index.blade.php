<x-board-layout boardName="{{ __('Trashed Posts') }}">
    

    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div class="mb-6 mt-6 p-4 rounded-lg bg-green-50 text-green-800 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <hr>

    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.adminShow', $post) }}">
                    <x-post-list :post="$post"/>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- 페이지네이션 링크 -->
    <div>
        {{ $posts->appends(['search' => request('search')])->links() }}
    </div>

    <br>
    <!-- 검색기능 -->
    <form action="{{ route('posts.trashed') }}" method="GET">
        @method('GET')
        <div class="flex gap-2 w-full justify-center">
            <x-text-input name="search" class="w-3/5" />
            <x-styled-button>{{ __('Search') }}</x-styled-button>
        </div>
    </form>
    <br>
</x-board-layout>