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