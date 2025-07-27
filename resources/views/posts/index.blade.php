@extends('layouts.app')

@section('title', 'Todos os Posts')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
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