<div class="bg-white p-6 rounded-lg shadow-md lg:mt-[68px]">

    <h3 class="font-bold text-lg mb-4 text-gray-800 border-b border-gray-200 pb-3">Filtrar e Ordenar</h3>
    
    <form action="{{ url()->current() }}" method="GET" class="space-y-4">
        <input type="hidden" name="postId" value="{{ request('postId') }}">
        
        {{-- Campo: Buscar por Título --}}
        <div>
            <label for="search" class="block text-sm font-medium text-gray-600 mb-1">Buscar por Título</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Ex: Laravel, Performance..."
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition">
        </div>

        {{-- Campo: Filtrar por Tag --}}
        <div>
            <label for="tags" class="block text-sm font-medium text-gray-600 mb-1">Filtrar por Tag</label>
            <input type="text" id="tag" name="tag" value="{{ request('tag') }}" placeholder="Ex: history, crime..."
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition">

        </div>

        {{-- Campo: Ordenar por --}}
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-600 mb-1">Ordenar por</label>
            <select id="sort" name="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition">
                {{-- Opções Padrão --}}
                <option value="latest" @selected(request('sort', 'latest') == 'latest')>Mais Recentes</option>
                <option value="oldest" @selected(request('sort') == 'oldest')>Mais Antigos</option>
                <option value="likes" @selected(request('sort') == 'likes')>Mais Curtidos</option>
                <option value="likes_asc" @selected(request('sort') == 'likes_asc')>Menos Curtidos</option>
                
            </select>
        </div>
        
        {{-- Botões de Ação --}}
        <div class="flex items-center space-x-2 pt-2">
            <button type="submit" class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                Filtrar
            </button>
            <a href="{{ url()->current() }}?postId={{ request('postId') }}" 
            class="flex-1 text-center bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition duration-200">
                Limpar
            </a>
        </div>
    </form>
</div>