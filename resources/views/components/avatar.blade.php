@props(['user', 'size' => 'h-11 w-11'])

@php
    // Valores padrão para evitar erros
    $imageUrl = null;
    $name = 'Usuário';

    // Garante que a variável $user não está vazia
    if (!empty($user)) {
        // Se for um objeto (usuário local do Eloquent)
        if (is_object($user)) {
            $imageUrl = $user->image ?? null;
            $name = "{$user->firstName} {$user->lastName}";
        }
        // Se for um array (usuário da API DummyJSON)
        elseif (is_array($user)) {
            $imageUrl = $user['image'] ?? null;
            // O nome pode ser completo ou apenas username
            if (isset($user['firstName'])) {
                $name = "{$user['firstName']} {$user['lastName']}";
            } else {
                $name = $user['username'] ?? 'Usuário';
            }
        }
    }

    // Decide a URL final: usa a imagem real se existir, senão gera uma com as iniciais
    $avatarUrl = !empty($imageUrl)
        ? $imageUrl
        : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=e0e0e0&color=222222&bold=true';
@endphp

{{-- O HTML final é o mesmo, mas agora a $avatarUrl estará sempre correta --}}
<img class="{{ $size }} rounded-full object-cover" src="{{ $avatarUrl }}" alt="Avatar de {{ $name }}">