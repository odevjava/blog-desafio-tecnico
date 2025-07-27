@php
    $currentSearch = request('search');
    $currentTag = request('tag');
@endphp

<div class="bg-white p-4 rounded-lg shadow space-y-4">
    <h3 class="text-lg font-semibold text-gray-800">Filtrar Posts</h3>

    {{-- Filtro por busca (título) --}}
    <form action="{{ url()->current() }}" method="GET" class="space-y-2">
        {{-- Preserve o returnTo na query --}}
        @if (request('returnTo'))
            <input type="hidden" name="returnTo" value="{{ request('returnTo') }}">
        @endif

        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Buscar por título:</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ex: Laravel"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>

        <div>
            <label for="tag" class="block text-sm font-medium text-gray-700">Tag:</label>
            <input type="text" name="tag" id="tag" value="{{ request('tag') }}" placeholder="Ex: backend"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>

        <div class="flex justify-between">
            <button type="submit"
                class="inline-block bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700">
                Aplicar Filtros
            </button>
            <a href="{{ url()->current() }}?returnTo={{ request('returnTo') }}"
            class="inline-block text-sm text-gray-500 hover:text-gray-700">
                Limpar
            </a>
        </div>
    </form>

</div>
