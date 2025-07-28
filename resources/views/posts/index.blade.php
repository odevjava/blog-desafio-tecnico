@extends('layouts.app')

@section('featured')
    {{-- Banner de Destaque com mais espaço abaixo --}}
    <div class="rounded-lg overflow-hidden shadow-lg mb-12 h-96">
        <img src="{{ asset('images/image1.png') }}"
             alt="Banner Principal" 
             class="w-full h-full object-cover">
    </div>
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Todos os Posts</h1>
    </div>

    <div class="space-y-6">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-500">Nenhum post encontrado.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection