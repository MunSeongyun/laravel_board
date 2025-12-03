<x-board-layout boardName="{{ __('BoardName') }}">
    <!-- 성공 메시지 표시 -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl">{{ $post->title }}</h1>
    
    <p>
        <strong>{{ __('Writer in post show') }}</strong> {{ $post->user->name ?? __('Unknown') }} (ID: {{ $post->user_id }})
    </p>
    
    <hr>

    <div class="mt-4 mb-4">
        {!! $post->content !!}
    </div>

    <!-- ================== [파일 목록 영역 시작] ================== -->
    @if($post->uploadedFiles->isNotEmpty())
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">
                {{ __('Attached Files') }} 
                <span class="text-sm font-normal text-gray-500">({{ $post->uploadedFiles->count() }})</span>
            </h3>
            <ul class="space-y-2">
                @foreach ($post->uploadedFiles as $file)
                    <li class="flex items-center text-sm">
                        @if ($file->trashed())
                            <!-- [관리자용] 삭제된 파일 스타일: 빨간색 + 취소선 + 불투명도 조절 -->
                            <a href="{{ route('posts.downloadDeletedAttachment',$file) }}">
                                <span class="flex items-center text-red-500 opacity-70" title="{{ __('Deleted File') }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span class="line-through">{{ $file->file_name }}</span>
                                    <span class="ml-2 text-xs border border-red-500 px-1 rounded">{{ __('Deleted') }}</span>
                                </span>
                            </a>
                        @else
                            <!-- [일반] 정상 파일 스타일: 파란색 링크 -->
                            <a href="{{ route('posts.downloadAttachment',$file) }}" class="flex items-center text-blue-600 hover:underline dark:text-blue-400" download>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                {{ $file->file_name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif


    <hr class="mb-4">

    <div class="flex gap-2 flex-row-reverse">

    <x-styled-a href="{{ route('posts.index') }}">{{ __('Return post list') }}</x-styled-a>

    @if ($post->trashed())
        
            @can('restore', $post)
                <form action="{{ route('posts.restore', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                    @csrf
                    @method('PATCH')
                    <x-styled-button type="submit" 
                    onclick="return confirm( '{{ __('Restore confirmation') }}' )">{{ __('Restore') }}</x-styled-button>
                </form>
            @endcan

            @can('forceDelete', $post)
                <form action="{{ route('posts.forceDelete', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                    @csrf
                    @method('DELETE')
                    <x-styled-button type="submit" 
                    onclick="return confirm( '{{ __('ForceDelete confirmation') }}'  )">{{ __('Force Delete') }}</x-styled-button>
                </form>
            @endcan
        
    @else
        <div class="flex gap-2 flex-row-reverse">
            @can('update', $post)
                <x-styled-a href="{{ route('posts.edit', $post) }}">{{ __('Edit') }}</x-styled-a>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                    @csrf
                    @method('DELETE')
                    <x-styled-button type="submit" onclick="return confirm( '{{ __('Delete confirmation') }}' )">{{ __('Delete') }}</x-styled-button>
                </form>
            @endcan 
        
    @endif
    </div>      
    <br>
</x-board-layout>