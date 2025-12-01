<x-board-layout :boardName="'삭제된 게시글'">
    

    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
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
        {{ $posts->links() }}
    </div>
</x-board-layout>