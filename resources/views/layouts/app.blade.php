<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog Laravel')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    {{-- NAVBAR --}}
    <header class="bg-blue-600 shadow-md">
        <nav class="container mx-auto p-4 flex justify-between items-center">
            
            {{-- MUDANÇA 2: Logo "Meu.blog" com texto branco e efeito hover --}}
            <a href="{{ route('posts.index') }}" class="text-2xl font-bold text-white hover:text-blue-200 transition-colors duration-200">
                Meu.blog
            </a>
        </nav>
    </header>
    {{-- FIM DA NOVA NAVBAR --}}

    <main class="container mx-auto px-4 py-8">
        @hasSection('header')
            @yield('header')
        @else
            <div class="mb-8 text-center">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">@yield('title')</h1>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="@if(isset($hideSidebar) && $hideSidebar) lg:col-span-4 @else lg:col-span-3 @endif">
                @yield('content')
            </div>
            @if(!isset($hideSidebar) || !$hideSidebar)
                <aside class="lg:col-span-1">
                    @yield('sidebar')
                </aside>
            @endif
        </div>
    </main>
    
    @if (session('success'))
        <div id="flash-message" class="fixed top-24 right-8 bg-blue-500 text-white py-2 px-4 rounded-lg shadow-lg transition-opacity duration-300">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                const flashMessage = document.getElementById('flash-message');
                if (flashMessage) {
                    flashMessage.style.opacity = '0';
                    setTimeout(() => flashMessage.remove(), 300);
                }
            }, 3000);
        </script>
    @endif
    
    <footer class="text-center text-sm text-gray-500 py-4 mt-8">
        Desenvolvido por Kevin Anderson &copy; {{ date('Y') }}. Todos os direitos reservados.
    </footer>

    {{-- O script de reações foi REMOVIDO daqui --}}

    
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
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
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
    @stack('scripts')
</body>
</html>