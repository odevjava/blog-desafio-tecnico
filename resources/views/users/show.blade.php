@extends('layouts.app')

@section('title', 'Detalhes de: ' . $user->firstName . ' ' . $user->lastName)
@php $hideSidebar = true; @endphp

@section('content')
    
    {{-- Exibe o cabeçalho do usuário --}}
    <div class="flex flex-col items-center">

        @php
            $param = request()->has('postId') ? '?postId=' . request('postId') : '';
        @endphp

        <div class="mb-6 w-full max-w-4xl">
            <a href="{{ route('users.posts', $user->id) }}{{$param}}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                &larr; Voltar para os posts de {{ $user->firstName }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md px-12 py-16 w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                {{-- Coluna Esquerda: Avatar e Nome --}}
                <div class="md:col-span-1 flex flex-col items-center justify-center text-center">
                    <img class="h-32 w-32 rounded-full object-cover mb-5" src="{{ $user->image }}" alt="Avatar de {{ $user->firstName }}">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $user->firstName }} {{ $user->lastName }}</h2>
                </div>

                {{-- Coluna Direita: Detalhes --}}
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-bold text-gray-800">Detalhes do Usuário</h3>
                    <hr class="my-4">
                    <div class="space-y-5 text-base text-gray-700">
                        <div>
                            <strong class="font-semibold">Email:</strong>
                            <span class="ml-3">{{ $user->email }}</span>
                        </div>
                        <div>
                            <strong class="font-semibold">Telefone:</strong>
                            <span class="ml-3">{{ $user->phone ?? 'Não informado' }}</span>
                        </div>
                        <div>
                            <strong class="font-semibold">Data de Nasc.:</strong>
                            <span class="ml-3">{{ isset($user->birthDate) ? \Carbon\Carbon::parse($user->birthDate)->format('d/m/Y') : 'Não informado' }}</span>
                        </div>
                        <div>
                            <strong class="font-semibold">Endereço:</strong>
                            <span class="ml-3">{{ $user->address->address ?? 'Não informado' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection