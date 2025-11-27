<x-board-layout>
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
        <a
        href="{{ route('posts.create') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
        >
            새 글 작성하기
        </a>
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
        {{ $posts->links() }}
    </div>
    <br>
</x-board-layout>