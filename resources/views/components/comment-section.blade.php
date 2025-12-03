@props(['post']) 

<div class="mt-8">
    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
        {{ __('Comments') }} <span class="text-base font-normal text-gray-500">({{ $post->comments->count() }})</span>
    </h3>

    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <form action="{{ route('posts.comments.store', $post) }}" method="POST">
            @csrf
            <div class="mb-2">
                
                <x-trix-input id="content" name="content" value="{!! old('content') !!}" acceptFiles="true"/>

                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <x-styled-button type="submit" class="text-xs px-3 py-2">
                    {{ __('Submit') }}
                </x-styled-button>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse ($post->comments as $comment)
        
            @if($comment->trashed())
                <!-- [스타일 A] 삭제된 댓글 -->
                <div class="p-4 bg-gray-100 rounded-lg border border-gray-200 opacity-75 dark:bg-gray-900 dark:border-gray-700">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center">
                            <span class="font-bold text-sm text-gray-500 dark:text-gray-500 mr-2">
                                {{ $comment->user->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-500">
                                {{ $comment->created_at->format('Y-m-d H:i') }}
                            </span>
                            <span class="ml-2 text-xs text-red-500 border border-red-500 px-1 rounded">
                                {{ __('Deleted Comment') }}
                            </span>
                        </div>
                    <div class="flex gap-2">
                        <!-- 관리자용 복원 버튼 -->
                        @can('restore', $comment)
                            <form action="{{ route('comments.restore', $comment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-gray-400 hover:text-green-600 transition-colors" onclick="return confirm('{{ __('Are you sure you want to restore this comment?') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                </button>
                            </form>
                        @endcan

                        <!-- 관리자용 영구삭제 버튼 -->
                        @can('forceDelete', $comment)
                                <form action="{{ route('comments.forceDelete', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('{{ __('Are you sure you want to permanently delete this comment?') }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                        @endcan
                    </div>
                    
                    </div>
                    <!-- 본문 (취소선 적용) -->
                    <div class="text-sm text-gray-500 dark:text-gray-500 line-through prose prose-sm max-w-none">
                        {!! $comment->content !!}
                    </div>
                </div>

            @else
                <!-- [스타일 B] 일반 댓글 -->
                <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center">
                            <span class="font-bold text-sm text-gray-900 dark:text-white mr-2">
                                {{ $comment->user->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->format('Y-m-d H:i') }}
                            </span>
                        </div>

                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endcan
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                        {!! $comment->content !!}
                    </div>
                </div>
            @endif

        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                {{ __('No comments yet. Be the first to comment!') }}
            </p>
        @endforelse
    </div>
</div>