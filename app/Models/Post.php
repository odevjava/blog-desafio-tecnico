<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body',
        'tags', 
        'reactions',
        'views',    
        'likes',
        'dislikes'
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    
    public function scopeFilter($query, array $filters)
    {
        // Filtra por termo de busca no título
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        // Filtra por tag
        $query->when($filters['tag'] ?? false, function ($query, $tag) {
            return $query->where('tags', 'like', '%' . $tag . '%');
        });
    }
    // Define o relacionamento com o modelo User.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Define o relacionamento com o modelo Comment.
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // Define o relacionamento com o modelo User para reações.
    public function getTagsAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) ?? [] : [];
    }

}