<x-board-layout :boardName="'게시판'">
    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl">{{ $post->title }}</h1>
    
    <p>
        <strong>작성자:</strong> {{ $post->user->name ?? '알 수 없음' }} (ID: {{ $post->user_id }})
    </p>
    
    <hr>

    <div style="white-space: pre-wrap; margin-bottom: 20px;">
        {!! $post->content !!}
    </div>

    <hr>

    <a href="{{ route('posts.index') }}">목록으로 돌아가기</a>

    @if ($post->trashed())
        @can('restore', $post)
            <form action="{{ route('posts.restore', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                @csrf
                @method('PATCH')
                <button type="submit" onclick="return confirm('정말 복원하시겠습니까?')">복원</button>
            </form>
        @endcan

        @can('forceDelete', $post)
            <form action="{{ route('posts.forceDelete', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('정말 영구삭제하시겠습니까?')">영구삭제</button>
            </form>
        @endcan 
    @else
        @can('update', $post)
            <a href="{{ route('posts.edit', $post) }}">수정</a>
        @endcan

        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</button>
            </form>
        @endcan 
    @endif
</x-board-layout>