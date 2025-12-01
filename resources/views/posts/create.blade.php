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

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf <!-- CSRF 토큰 -->
        <div>
            <x-input-label for="title" :value="__('Title in post create')"/>
            <x-text-input id="title" name="title" value="{{ old('title') }}" class="w-full" />
        </div>
        <br>
        <div>
            <x-input-label for="content" :value="__('Content in post create')" />
            <!-- views/components/trix-input.blade.php 파일 불러옴 -->
            <x-trix-input id="content" name="content" value="{!! old('content') !!}" acceptFiles="true"/>
        </div>
        <br>
        <div class="flex gap-2 flex-row-reverse">
            <x-styled-button type="submit">{{ __('Save') }}</x-styled-button>
            <x-styled-a href="{{ route('posts.index') }}">{{ __('Return post list') }}</x-styled-a>
        </div>
        
    </form>

    
</x-board-layout>