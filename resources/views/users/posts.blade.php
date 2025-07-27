@extends('layouts.app')

@section('title', '')

@section('header')

    <div class="mb-6">
        
        @php
            {{ $profileUrl = route('users.show', $user->id); }}
            {{ $backUrl = (url()->previous() == $profileUrl) ? route('posts.index') : url()->previous(); }}
            $param = request()->has('postId') ? '?postId=' . request('postId') : '';
        @endphp
        
        {{-- Link de Voltar --}}
        <a href="{{ request()->has('postId') ? route('posts.show', request('postId')) : route('posts.index') }}"
        class="inline-flex items-center text-blue-600 hover:text-blue-800 hover:underline font-semibold text-sm transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Voltar
        </a>     
    </div>

    {{-- Resto do seu Hero Section --}}
    <div class="relative h-56 rounded-lg overflow-hidden bg-cover bg-center mb-8" 
         style="background-image: url('{{ $user->cover_image_url ?? 'https://images.unsplash.com/photo-1554189097-90d8360ae8df' }}');">
        
        <div class="absolute inset-0 bg-black/60"></div>
        
        <div class="relative h-full flex items-center p-8">
            <div class="flex items-center gap-5">
                <img class="h-24 w-24 rounded-full object-cover border-4 border-white" src="{{ $user->image }}" alt="Avatar de {{ $user->firstName }}">
                <div>
                    <p class="text-sm text-gray-200">Posts de:</p>
                    <h1 class="text-4xl font-bold text-white">{{ $user->firstName }} {{ $user->lastName }}</h1>
                </div>
            </div>
        </div>

        <a href="{{ route('users.show', $user->id) }}{{$param}}" class="absolute bottom-6 right-8 bg-white/90 text-gray-900 font-semibold py-2 px-5 rounded-md hover:bg-white transition duration-200">
            Ver Perfil
        </a>
    </div>
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-500">{{ $user->firstName }} ainda não publicou nenhum post.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection