<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class StorePreviousUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        // Obtém o nome da rota atual
        $routeName = Route::currentRouteName();

        $routesToIgnore = [
            'users.posts',
            'users.show', // <-- ADICIONE ESTA LINHA
            'posts.like',
            'posts.dislike',
        ];

        // Verifica se a rota atual não está na lista de rotas a ignorar
        if (!in_array($routeName, $routesToIgnore)) {
            session(['return_to_url' => url()->full()]);
        }
        
        return $next($request);
    }
}