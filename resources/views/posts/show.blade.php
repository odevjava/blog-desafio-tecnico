@extends('layouts.app')

@section('title', "Post de: {$post->user->firstName} {$post->user->lastName}")
@php $hideSidebar = true; @endphp

@section('content')

    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 hover:underline font-semibold text-sm transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Voltar para todos os posts
        </a>
    </div>

    {{-- Seção do Post --}}
    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>
        <div class="mt-4 text-sm text-gray-500 flex items-center space-x-4">
            <span>Por: 
                <a href="{{ route('users.posts', $post->user->id) }}?postId={{ $post->id }}" class="text-gray-900 font-semibold hover:text-blue-600">
                    {{ $post->user->firstName }} {{ $post->user->lastName }}
                </a>
            </span>
            <span>&bull;</span>
            <span>{{ $post->created_at->format('d/m/Y') }}</span>
            <span>&bull;</span>
            <span>Visualizações: {{ $post->views }}</span>
        </div>
        @if (!empty($post->tags))
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2"></h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag]) }}"
                        class="inline-block px-3 py-1 text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full">
                            #{{ $tag }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <hr class="my-6">
        <div class="prose prose-lg max-w-none text-gray-800">{{ $post->body }}</div>
        
        <hr class="my-8">

        {{-- BOTÕES DE LIKE/DISLIKE COM AJAX --}}
        <x-post-reactions :post="$post" />

    </div>
    
    {{-- Seção de Comentários (Apenas Exibição da API) --}}
    <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Comentários ({{ count($apiComments) }})
        </h2>
        <div class="space-y-8">
            @forelse ($apiComments as $apiComment)
                <div class="comment-container">
                    {{-- CABEÇALHO DO COMENTÁRIO: Alinhado ao centro --}}
                    <div class="flex items-center space-x-4">
                        {{-- Coluna 1: Avatar --}}
                        <a href="{{ route('users.posts', $apiComment['user']['id']) }}">
                            {{-- O componente de avatar já está a funcionar bem aqui --}}
                            <x-avatar :user="$apiComment['user']" />
                        </a>
                        {{-- Coluna 2: Nome do Autor --}}
                        <div class="flex-1">
                            <a href="{{ route('users.posts', $apiComment['user']['id']) }}" class="text-base font-bold text-gray-900 hover:text-blue-600">
                                {{ $apiComment['user']['firstName'] }} {{ $apiComment['user']['lastName'] }}
                            </a>
                            {{-- Poderia adicionar o timestamp aqui se quisesse, ex: <p class="text-xs text-gray-500">há 2 horas</p> --}}
                        </div>
                    </div>

                    {{-- CORPO DO COMENTÁRIO  --}}
                    <div class="pl-16 pt-2"> {{-- A margem 'pl-16' alinha o texto por baixo do nome --}}
                        <div class="bg-gray-100 rounded-lg p-4">
                            <p class="text-gray-700">{{ $apiComment['body'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Ainda não há comentários.</p>
            @endforelse
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function handleReaction(event) {
            const button = event.target.closest('.reaction-btn');
            if (!button) return;

            event.preventDefault();

            const url = button.dataset.url;
            const postId = button.dataset.postId;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json' 
                    },
                });

                if (!response.ok) throw new Error('A resposta da rede não foi OK');
                const data = await response.json();

                document.getElementById(`likes-count-${postId}`).textContent = data.likes;
                document.getElementById(`dislikes-count-${postId}`).textContent = data.dislikes;

                const likeIcon = document.getElementById(`like-icon-${postId}`);
                const dislikeIcon = document.getElementById(`dislike-icon-${postId}`);

                likeIcon.classList.remove('text-blue-600');
                likeIcon.setAttribute('fill', 'none');
                dislikeIcon.classList.remove('text-red-600');
                dislikeIcon.setAttribute('fill', 'none');

                if (data.currentInteraction === 'like') {
                    likeIcon.classList.add('text-blue-600');
                    likeIcon.setAttribute('fill', 'currentColor');
                } else if (data.currentInteraction === 'dislike') {
                    dislikeIcon.classList.add('text-red-600');
                    dislikeIcon.setAttribute('fill', 'currentColor');
                }
            } catch (error) {
                console.error(`Erro ao processar a interação para o post ${postId}:`, error);
            }
        }

        document.body.addEventListener('click', handleReaction);
    });
</script>
@endsection