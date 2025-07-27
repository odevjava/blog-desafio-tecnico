<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'email',
        'phone',
        'image',
        'birthDate',
        'address'
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getCoverImageUrlAttribute(): string
    {
        // Usa ID do usuário como "semente" para a imagem.
        // Isso garante que a imagem seja sempre a mesma para este usuário.
        // 1200x400 são as dimensões da imagem (largura x altura).
        return "https://picsum.photos/seed/{$this->id}/1200/400";
    }
}