@props(['post'])

@php
    $interactionKey = 'post_interaction.' . $post->id;
    $currentInteraction = session($interactionKey);
@endphp

<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <div class="p-6">
        {{-- Cabeçalho do Card (com links de navegação inteligentes) --}}
        <div class="flex items-center mb-4">
            <a href="{{ route('users.posts', ['user' => $post->user, 'returnTo' => Request::fullUrl()]) }}">
                <img class="h-11 w-11 rounded-full object-cover" src="{{ $post->user->image }}" alt="Avatar de {{ $post->user->firstName }}">
            </a>
            <div class="ml-4 text-sm">
                <a href="{{ route('users.posts', ['user' => $post->user, 'returnTo' => Request::fullUrl()]) }}" class="text-gray-900 font-bold hover:text-blue-600">
                    {{ $post->user->firstName }} {{ $post->user->lastName }}
                </a>
                <p class="text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>

        {{-- Conteúdo do Post --}}
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 leading-tight">
                <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-700 transition-colors duration-200">
                    {{ $post->title }}
                </a>
            </h2>
            <div class="flex flex-wrap gap-2 mb-5">
                @foreach ($post->tags as $tag)
                    <span class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-full capitalize">#{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        
        {{-- RODAPÉ INTERATIVO --}}
        <div class="border-t border-gray-200 pt-4 flex items-center text-gray-500 text-sm space-x-6">
            
            {{-- Visualizações (não interativo) --}}
            <div class="flex items-center gap-1.5" title="Visualizações">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
            <path d="M21 12c-2.4 4 -5.4 6 -9 6s-6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6s6.6 2 9 6" />
            </svg>
            <span>{{ $post->views }}</span>
        </div>

            {{-- Botões de Reação (Like/Dislike) --}}

            <x-post-reactions :post="$post" />

            {{-- Link para Comentários --}}
            <a href="{{ route('posts.show', $post) }}#comments" class="flex items-center gap-1.5 text-gray-500 hover:text-gray-900 transition-colors duration-200" title="Ver comentários">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                <path d="M12 12l0 .01" />
                <path d="M8 12l0 .01" />
                <path d="M16 12l0 .01" />
                </svg>
                <span>{{ optional($post->comments)->count() ?? $apiComments[$post->id] ?? 0 }}</span>
            </a>
        </div>
    </div>
</article>