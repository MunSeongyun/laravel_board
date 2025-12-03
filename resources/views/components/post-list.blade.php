@props(['post'])
<div class="flex justify-between items-center mb-2">
    <div><strong>{{ $post->title }}</strong></div>
    <div>{{ $post->user->name ?? __('Unknown') }}</div>
</div>
<hr>
