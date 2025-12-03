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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
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

        <!-- 파일 첨부 입력 필드 -->
        <div>
            <x-input-label for="uploaded_files" :value="__('Attachments')" />
            
            <!-- 1. multiple: 여러 파일 선택 가능하게 함, 2. name="uploaded_files[]": 컨트롤러에서 배열 형태로 받기 위해 이름 뒤에 [] 추가  -->
            <input 
                id="uploaded_files" 
                type="file" 
                name="uploaded_files[]" 
                multiple
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            >
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">
                {{ __('Maximum file size: 5MB per file.') }}
            </p>
        </div>

        <br>
        <div class="flex gap-2 flex-row-reverse">
            <x-styled-button type="submit">{{ __('Save') }}</x-styled-button>
            <x-styled-a href="{{ route('posts.index') }}">{{ __('Return post list') }}</x-styled-a>
        </div>
        
    </form>

    
</x-board-layout>