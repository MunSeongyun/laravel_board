<x-app-layout>
    <h1>게시글 목록</h1>

    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('posts.create') }}">새 글 작성하기</a>

    <hr>

    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- 페이지네이션 링크 -->
    <div>
        {{ $posts->links() }}
    </div>
</x-app-layout>