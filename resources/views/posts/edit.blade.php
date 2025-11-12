<x-app-layout>
    <h1>글 수정</h1>

    <!-- 유효성 검사 에러 표시 -->
    @if ($errors->any())
        <div style="color: red;">
            <strong>이런! 문제가 발생했습니다.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf <!-- CSRF 토큰 -->
        @method('PUT') <!-- HTTP PUT 메소드 사용 -->

        <div>
            <label for="title">제목:</label><br>
            <!-- 기존 데이터 표시 -->
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" style="width: 300px;">
        </div>
        <br>
        <div>
            <label for="content">내용:</label><br>
            <!-- 기존 데이터 표시 -->
            <textarea id="content" name="content" rows="10" cols="50">{{ old('content', $post->content) }}</textarea>
        </div>
        <br>
        <button type="submit">수정하기</button>
    </form>

    <a href="{{ route('posts.show', $post) }}">수정 취소</a>
</x-app-layout>