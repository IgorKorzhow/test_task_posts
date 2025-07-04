<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'header',
        'content',
        'hotness',
    ];

    public function watchedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watched_user_post')->withTimestamps();
    }
}
