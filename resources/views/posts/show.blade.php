<x-app-layout>
    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <h1>{{ $post->title }}</h1>
    <p>
        <strong>작성자:</strong> {{ $post->user->name ?? '알 수 없음' }} (ID: {{ $post->user_id }})
    </p>
    
    <hr>

    <div style="white-space: pre-wrap; margin-bottom: 20px;">
        {{ $post->content }}
    </div>

    <hr>

    <a href="{{ route('posts.index') }}">목록으로 돌아가기</a>

    <!-- PostPolicy의 'update' 권한이 있는 사용자에게만 보임 -->
    @can('update', $post)
        <a href="{{ route('posts.edit', $post) }}">수정</a>
    @endcan

    <!-- PostPolicy의 'delete' 권한이 있는 사용자에게만 보임 -->
    @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</button>
        </form>
    @endcan
</x-app-layout>