@props(['post'])
<div class="flex justify-between items-center mb-2">
    <div><strong>{{ $post->title }}</strong></div>
    <div>{{ $post->user->name }}</div>
</div>
<hr>
