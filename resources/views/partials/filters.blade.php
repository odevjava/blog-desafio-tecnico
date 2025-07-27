<div class="bg-white p-4 rounded-lg shadow-md mb-8">
    <form action="{{ $action }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        {{-- Busca por Título --}}
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Buscar por Título</label>
            <input type="text" name="search" id="search"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   placeholder="Ex: Laravel, Performance..."
                   value="{{ request('search') }}">
        </div>

        {{-- Busca por Tag --}}
        <div>
            <label for="tag" class="block text-sm font-medium text-gray-700">Filtrar por Tag</label>
            <input type="text" name="tag" id="tag"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   placeholder="Ex: history, crime..."
                   value="{{ request('tag') }}">
        </div>

        {{-- Ordenação --}}
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700">Ordenar por</label>
            <select name="sort" id="sort"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Mais Recentes</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Mais Antigos</option>
                <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>Mais Curtidos</option>
                <option value="likes_asc" {{ request('sort') == 'likes_asc' ? 'selected' : '' }}>Menos Curtidos</option>
            </select>
        </div>

        {{-- Botões --}}
        <div class="flex items-center gap-2">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Filtrar
            </button>
            <a href="{{ $action }}" class="w-full text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Limpar
            </a>
        </div>
    </form>
</div>