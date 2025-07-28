@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['extraClasses' => 'lg:mt-[68px]'])
@endsection

@section('featured')
    <div class="relative w-full rounded-lg overflow-hidden shadow-lg mb-12 h-96" 
         x-data="carousel()">

        <template x-for="slide in slides" :key="slide.id">
            <div x-show="activeSlide === slide.id" class="absolute inset-0 transition-opacity duration-[1500ms] ease-in-out">
                <img :src="slide.image" class="absolute block w-full h-full object-cover" :alt="slide.title">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end p-6 md:p-10">
                    <h2 class="text-white text-3xl md:text-4xl font-bold" x-text="slide.title"></h2>
                </div>
            </div>
        </template>

        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-30 flex space-x-3">
            <template x-for="slide in slides" :key="slide.id">
                <button @click="activeSlide = slide.id" 
                        class="w-2 h-2 rounded-full transition-colors"
                        :class="{'bg-white': activeSlide === slide.id, 'bg-white/50 hover:bg-white/75': activeSlide !== slide.id}">
                </button>
            </template>
        </div>
    </div>
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

@push('scripts')
<script>
    function carousel() {
        return {
            activeSlide: 1,
            slides: @json($carouselSlides),
            
            // Avança para o próximo slide
            nextSlide() {
                this.activeSlide = (this.activeSlide % this.slides.length) + 1;
            },

            // Volta para o slide anterior
            prevSlide() {
                this.activeSlide = this.activeSlide === 1 ? this.slides.length : this.activeSlide - 1;
            },

            // Inicia o autoplay
            init() {
                setInterval(() => {
                    this.nextSlide();
                }, 6000); // Muda a cada 6 segundos
            }
        }
    }
</script>
@endpush