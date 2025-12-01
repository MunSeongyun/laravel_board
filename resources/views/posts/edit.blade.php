<x-board-layout boardName="{{ __('BoardName') }}">
    <br>
    <!-- 유효성 검사 에러 표시 -->
    @if ($errors->any())
        <div style="color: red;">
            <strong>{{ __('Error occurred!') }}</strong>
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
            <x-input-label for="title" :value="__('Title in post create')"/>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="w-full">
        </div>
        <br>
        <div>
            <x-input-label for="content" :value="__('Content in post create')" />
            <!-- 기존 데이터 표시 -->
            <x-trix-input id="content" name="content" value="{!! old('content', $post->content->toTrixHtml()) !!}" acceptFiles="true"/>
        </div>
        <br>
        <div class="flex gap-2 flex-row-reverse">
            <x-styled-button type="submit">{{ __('Edit in post edit') }}</x-styled-button>
            <x-styled-a href="{{ route('posts.show', $post) }}" >{{ __('Cancel in post edit') }}</x-styled-a>
        </div>
    </form>
    
    
</x-board-layout>