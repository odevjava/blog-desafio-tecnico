@props(['post'])

<div class="flex items-center space-x-5">
    {{-- Botão de Like --}}
    <button type="button"
            data-post-id="{{ $post->id }}"
            data-url="{{ route('posts.like', $post->id) }}"
            class="reaction-btn flex items-center space-x-1.5 text-gray-500 transition-colors duration-200 hover:text-blue-600">
        
        <svg id="like-icon-{{ $post->id }}"
             @class(['w-6 h-6', 'text-blue-600' => session('post_interaction.' . $post->id) === 'like'])
             fill="{{ session('post_interaction.' . $post->id) === 'like' ? 'currentColor' : 'none' }}"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
        </svg>
        <span id="likes-count-{{ $post->id }}">{{ $post->likes }}</span>
    </button>

    {{-- Botão de Dislike --}}
    <button type="button"
            data-post-id="{{ $post->id }}"
            data-url="{{ route('posts.dislike', $post->id) }}"
            class="reaction-btn flex items-center space-x-1.5 text-gray-500 transition-colors duration-200 hover:text-red-600">

        <svg id="dislike-icon-{{ $post->id }}"
             @class(['w-6 h-6', 'text-red-600' => session('post_interaction.' . $post->id) === 'dislike'])
             fill="{{ session('post_interaction.' . $post->id) === 'dislike' ? 'currentColor' : 'none' }}"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" />
        </svg>
        <span id="dislikes-count-{{ $post->id }}">{{ $post->dislikes }}</span>
    </button>
</div>