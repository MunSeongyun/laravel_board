<x-app-layout>
    <h1>새 글 작성</h1>

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

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf <!-- CSRF 토큰 -->
        <div>
            <label for="title">제목:</label><br>
            <input type="text" id="title" name="title" value="{{ old('title') }}" style="width: 300px;">
        </div>
        <br>
        <div>
            <label for="content">내용:</label><br>
            <x-trix-input id="content" name="content" value="{!! old('content') !!}" acceptFiles="true"/>
        </div>
        <br>
        <button type="submit">저장하기</button>
    </form>

    <a href="{{ route('posts.index') }}">목록으로 돌아가기</a>
</x-app-layout>