<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class SyncApiData extends Command
{
    protected $signature = 'sync:api-data';
    protected $description = 'Sincroniza users, posts, and comments from DummyJSON API to the local database';

    public function handle()
    {
        $this->info('Iniciando sincronização de dados da API DummyJSON...');

        DB::transaction(function () {
            $this->info('Limpando tabelas existentes...');
            // A ordem é importante para respeitar as chaves estrangeiras
            Comment::query()->delete();
            Post::query()->delete();
            User::query()->delete();

            // --- PASSO 1: IMPORTAR TODOS OS USUÁRIOS PRIMEIRO ---
            $this->info('Sincronizando usuários...');
            // Usamos limit=0 para pedir à API todos os registros disponíveis (uma prática comum)
            $usersResponse = Http::get('https://dummyjson.com/users?limit=0');
            if ($usersResponse->successful()) {
                foreach ($usersResponse->json()['users'] as $userData) {
                    $addressData = $userData['address'] ?? [];
                    User::create([
                        'id' => $userData['id'],
                        'firstName' => $userData['firstName'],
                        'lastName' => $userData['lastName'],
                        'email' => $userData['email'],
                        'phone' => $userData['phone'],
                        'image' => $userData['image'],
                        'birthDate' => $userData['birthDate'],
                        'address' => json_encode($addressData), // Usando json_encode para consistência
                    ]);
                }
                $this->info('Usuários sincronizados com sucesso! Total: ' . User::count());
            } else {
                $this->error('Falha ao obter usuários da API. Abortando.');
                return; // Aborta a transação se os usuários falharem
            }

            // CRIAR UMA LISTA DE IDs DE USUÁRIOS VÁLIDOS 
            
            $existingUserIds = array_flip(User::pluck('id')->all());
            $this->info(count($existingUserIds) . ' IDs de usuários carregados para validação.');

            // IMPORTAR OS POSTS VALIDANDO O USER_ID
            $this->info('Sincronizando posts...');
            $postsResponse = Http::get('https://dummyjson.com/posts?limit=0');
            if ($postsResponse->successful()) {
                foreach ($postsResponse->json()['posts'] as $postData) {
                    // VERIFICAÇÃO CRÍTICA: O usuário deste post existe na nossa lista?
                    if (isset($existingUserIds[$postData['userId']])) {
                        $tagsArray = $postData['tags'] ?? [];
                        $reactionsData = $postData['reactions'] ?? ['likes' => 0, 'dislikes' => 0];

                        Post::create([
                            'id' => $postData['id'],
                            'title' => $postData['title'],
                            'body' => $postData['body'],
                            'user_id' => $postData['userId'],
                            'tags' => json_encode($tagsArray),
                            'reactions' => ($reactionsData['likes'] ?? 0) + ($reactionsData['dislikes'] ?? 0),
                            'views' => 0,
                            'likes' => $reactionsData['likes'] ?? 0,
                            'dislikes' => $reactionsData['dislikes'] ?? 0,
                        ]);
                    } else {
                        // Se o usuário não existir, pulamos o post e avisamos no console.
                        $this->warn('Pulando Post ID #' . $postData['id'] . ' - Usuário ID #' . $postData['userId'] . ' não encontrado.');
                    }
                }
                $this->info('Posts sincronizados com sucesso! Total: ' . Post::count());
            } else {
                $this->error('Falha ao obter posts da API.');
            }
            
            // Repetimos o processo para comentários
            $existingPostIds = array_flip(Post::pluck('id')->all());
            $this->info(count($existingPostIds) . ' IDs de posts carregados para validação de comentários.');

            $this->info('Sincronizando comentários...');
            $commentsResponse = Http::get('https://dummyjson.com/comments?limit=0');
            if ($commentsResponse->successful()) {
                foreach ($commentsResponse->json()['comments'] as $commentData) {
                    // Valida se o usuário e o post do comentário existem
                    if (isset($existingUserIds[$commentData['user']['id']]) && isset($existingPostIds[$commentData['postId']])) {
                         Comment::create([
                            'id' => $commentData['id'],
                            'body' => $commentData['body'],
                            'post_id' => $commentData['postId'],
                            'user_id' => $commentData['user']['id'],
                        ]);
                    } else {
                        $this->warn('Pulando Comentário ID #' . $commentData['id'] . ' - Post ou Usuário não encontrado.');
                    }
                }
                 $this->info('Comentários sincronizados com sucesso! Total: ' . Comment::count());
            } else {
                $this->error('Falha ao obter comentários da API.');
            }
        });

        $this->info('Sincronização de dados concluída!');
        return 0;
    }
}