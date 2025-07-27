<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{ 
    public function index(Request $request)
    {
        // Define a chave de cache baseada na URL completa da requisição.
        $cacheKey = 'posts.index.' . md5($request->fullUrl());

        // Verifica se os posts já estão em cache.
        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Post::query()->filter($request->only(['search', 'tag']));

            $sort = $request->input('sort', 'latest');
            if ($sort === 'likes') {
                $query->orderBy('likes', 'desc');
            } elseif ($sort === 'likes_asc') {
                $query->orderBy('likes', 'asc');
            } elseif ($sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } else {
                $query->latest();
            }

            // Carrega os posts com o usuário e a contagem de comentários.
            return $query->with('user')
                        ->withCount('comments')
                        ->paginate(30)
                        ->withQueryString();
        });

        // Limpa o cache de posts quando um novo post é criado ou atualizado.
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Ações locais (views)
        $post->increment('views');


        // Definição da variável de interação
        $interactionKey = 'post_interaction.' . $post->id;
        $currentInteraction = session($interactionKey);

        // Busca a lista de comentários da API
        $apiResponse = Http::withoutVerifying()->get("https://dummyjson.com/posts/{$post->id}/comments");
        $rawApiComments = ($apiResponse->successful() && isset($apiResponse->json()['comments'])) ? $apiResponse->json()['comments'] : [];

        // ENRIQUECER OS COMENTÁRIOS COM OS DADOS COMPLETOS DO USUÁRIO
        $enrichedApiComments = [];
        foreach ($rawApiComments as $comment) {
            $userId = $comment['user']['id'];

            // Busca os dados do usuário no cache ou na API (cache de 24 horas)
            $fullUser = \Illuminate\Support\Facades\Cache::remember("user_{$userId}", now()->addHours(24), function () use ($userId) {
                $userResponse = Http::withoutVerifying()->get("https://dummyjson.com/users/{$userId}");
                return $userResponse->successful() ? $userResponse->json() : null;
            });

            // Se os dados do usuário foram encontrados, substitui o usuário simples pelo usuário completo
            if ($fullUser) {
                $comment['user'] = $fullUser;
                $enrichedApiComments[] = $comment;
            }
        }

        // Busca os comentários salvos localmente
        $localComments = \App\Models\Comment::where('post_id', $post->id)->with('user')->latest()->get();

        // Envia os dados enriquecidos para a view
        return view('posts.show', [
            'post' => $post,
            'currentInteraction' => $currentInteraction,
            'apiComments' => $enrichedApiComments, // <-- Enviamos a lista com os dados completos
            'localComments' => $localComments,
        ]);
    }

    public function like(Request $request, Post $post)
    {
        // Lógica para lidar com a interação de "like" (permanece a mesma)
        $interactionKey = 'post_interaction.' . $post->id;
        $currentInteraction = session($interactionKey);

        if ($currentInteraction === 'like') {
            $post->decrement('likes');
            session()->forget($interactionKey);
        } elseif ($currentInteraction === 'dislike') {
            $post->decrement('dislikes');
            $post->increment('likes');
            session()->put($interactionKey, 'like');
        } else {
            $post->increment('likes');
            session()->put($interactionKey, 'like');
        }

        Cache::flush();
        $post->refresh(); // Recarrega o modelo do banco para pegar os valores atualizados

        // LÓGICA AJAX ADICIONADA
        if ($request->expectsJson()) {
            // ...retorne os novos dados.
            return response()->json([
                'likes' => $post->likes,
                'dislikes' => $post->dislikes,
                'currentInteraction' => session($interactionKey) // Retorna 'like' ou null
            ]);
        }
        
        // Comportamento antigo (fallback) se não for uma requisição AJAX
        return back()->with('success', 'Sua interação foi registrada com sucesso!');
    }

    public function dislike(Request $request, Post $post)
    {
        // Lógica para lidar com a interação de "dislike" (permanece a mesma)
        $interactionKey = 'post_interaction.' . $post->id;
        $currentInteraction = session($interactionKey);

        if ($currentInteraction === 'dislike') {
            $post->decrement('dislikes');
            session()->forget($interactionKey);
        } elseif ($currentInteraction === 'like') {
            $post->decrement('likes');
            $post->increment('dislikes');
            session()->put($interactionKey, 'dislike');
        } else {
            $post->increment('dislikes');
            session()->put($interactionKey, 'dislike');
        }
        
        Cache::flush();
        $post->refresh(); // Recarrega o modelo do banco para pegar os valores atualizados

        // LÓGICA AJAX ADICIONADA
        if ($request->expectsJson()) {
            // ...retorne os novos dados.
            return response()->json([
                'likes' => $post->likes,
                'dislikes' => $post->dislikes,
                'currentInteraction' => session($interactionKey) // Retorna 'dislike' ou null
            ]);
        }
        
        // Comportamento antigo (fallback) se não for uma requisição AJAX
        return back()->with('success', 'Sua interação foi registrada com sucesso!');
    }

}