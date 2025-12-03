<x-board-layout boardName="{{ __('BoardName') }}">
    <br>
    <!-- 유효성 검사 에러 표시 -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 dark:bg-gray-800 dark:border-red-800 dark:text-red-400">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <h3 class="font-bold">
                    {{ __('Error occurred!') }}
                </h3>
            </div>
            
            <ul class="list-disc list-inside text-sm ml-2 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
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

        <!-- ================== [기존 파일 관리] ================== -->
        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
            <h3 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Attached Files') }}</h3>
            
            @if($post->uploadedFiles->isEmpty())
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No files attached.') }}</p>
            @else
                <ul class="space-y-2">
                    @foreach($post->uploadedFiles as $file)
                        <li class="flex items-center space-x-3">
                            <!-- 삭제용 체크박스: 체크하면 value인 $file->id가 delete_files 배열로 전송됨 -->
                            <input 
                                id="file_{{ $file->id }}" 
                                type="checkbox" 
                                name="delete_files[]" 
                                value="{{ $file->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="file_{{ $file->id }}" class="text-sm font-medium text-gray-900 dark:text-gray-300">
                                <!-- 파일명 표시 -->
                                {{ $file->file_name ?? $file->original_name ?? 'Unknown File' }}
                                <span class="text-xs text-red-500 ml-2">({{ __('Check to delete') }})</span>
                            </label>
                            
                            <!-- 파일 다운로드/보기 링크 -->
                            <a href="{{ route('posts.downloadAttachment',$file) }}" target="_blank" class="text-xs text-blue-500 hover:underline">
                                [{{ __('Download') }}]
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <br>

        <!-- ================== [새 파일 추가] ================== -->
        <div>
            <x-input-label for="uploaded_files" :value="__('Add New Files')" />
            <input 
                id="uploaded_files" 
                type="file" 
                name="uploaded_files[]" 
                multiple
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            >
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                {{ __('New files will be added to the existing list.') }}
            </p>
        </div>  

        <div class="flex gap-2 flex-row-reverse">
            <x-styled-button type="submit">{{ __('Edit in post edit') }}</x-styled-button>
            <x-styled-a href="{{ route('posts.show', $post) }}" >{{ __('Cancel in post edit') }}</x-styled-a>
        </div>
    </form>
    
    
</x-board-layout>