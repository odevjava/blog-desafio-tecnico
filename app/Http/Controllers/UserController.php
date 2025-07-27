<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        // Carrega o usuário com seus posts e comentários.
        return view('users.show', compact('user'));
    }

    public function posts(Request $request, User $user)
    {
        // Filtra os posts do usuário com base nos filtros de busca e tag.
        $query = $user->posts()->filter($request->only(['search', 'tag']));

        // Ordena os posts com base na preferência do usuário.
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

        // Carrega os posts do usuário com a contagem de comentários.
        $posts = $query->withCount('comments')
                       ->paginate(15)
                       ->withQueryString();

        return view('users.posts', compact('user', 'posts'));
    }
}