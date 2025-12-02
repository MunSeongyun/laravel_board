<x-board-layout boardName="{{ __('BoardName') }}">
    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <br>
    <div
        class="flex justify-end mb-4"
    >
        <x-styled-a
        href="{{ route('posts.create') }}"
        >
            {{ __('Create New Post') }}
        </x-styled-a>
    </div>
    
    <hr>

    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">
                    <x-post-list :post="$post"/>
                </a>
            </li>
        @endforeach
    </ul>

    <br>
    <!-- 페이지네이션 링크, vendor/pagination의 tailwind.blade.php를 사용(퍼블리싱) -->
    <div>
        {{ $posts->appends(['search' => request('search')])->links() }}
    </div>
    <br>
    <!-- 검색기능 -->
    <form action="{{ route('posts.index') }}" method="GET">
        @method('GET')
        <div class="flex gap-2 w-full justify-center">
            <x-text-input name="search" class="w-3/5" />
            <x-styled-button>{{ __('Search') }}</x-styled-button>
        </div>
    </form>
    <br>
</x-board-layout>