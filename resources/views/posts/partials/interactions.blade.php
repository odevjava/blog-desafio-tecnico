{{-- Formulário de Like --}}
<form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline-block">
    @csrf
    @php
        $hasLiked = session('post_interaction.' . $post->id) === 'like';
    @endphp
    <button type="submit" class="flex items-center gap-1 hover:opacity-75 transition-opacity {{ $hasLiked ? 'text-blue-600' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.787l.09.044a2 2 0 002.243-.442l4.262-5.58A2 2 0 0013.566 10h1.934a2 2 0 002-2V4a2 2 0 00-2-2h-1.382a2 2 0 00-1.787 1.106L12.28 6.091V4a2 2 0 00-2-2H6a2 2 0 00-2 2v6.333z"/>
        </svg>
        <span>{{ $post->likes }}</span>
    </button>
</form>

{{-- Formulário de Dislike --}}
<form action="{{ route('posts.dislike', $post->id) }}" method="POST" class="inline-block">
    @csrf
    @php
        $hasDisliked = session('post_interaction.' . $post->id) === 'dislike';
    @endphp
    <button type="submit" class="flex items-center gap-1 hover:opacity-75 transition-opacity {{ $hasDisliked ? 'text-red-600' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.787l-.09-.044a2 2 0 00-2.243.442L6.298 8.42A2 2 0 006.434 10H4.5a2 2 0 00-2 2v4a2 2 0 002 2h1.382a2 2 0 001.787-1.106L7.72 13.909V16a2 2 0 002 2h4a2 2 0 002-2V9.667z"/>
        </svg>
        <span>{{ $post->dislikes }}</span>
    </button>
</form>

{{-- Contador de Comentários --}}
<a href="{{ route('posts.show', $post->id) }}#comments" class="flex items-center gap-1 text-gray-500 hover:text-gray-700">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.08-3.239A8.969 8.969 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.72 14.48A6.94 6.94 0 008 15c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6c0 1.314.41 2.533 1.115 3.561L4 14.48z" clip-rule="evenodd"/>
    </svg>
    <span>{{ $post->comments_count }}</span>
</a>