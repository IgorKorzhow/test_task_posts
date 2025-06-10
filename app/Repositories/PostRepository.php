<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository
{
    public function getPaginatedNotWatchedAndNotOverheated(array $conditions, $perPage = 15): LengthAwarePaginator
    {
        $sortField = $conditions['sort_field'] ?? 'hotness';
        $softOrder = $conditions['sort_order'] ?? 'asc';

        return Post::query()
            ->whereDoesntHave('watchedByUsers', fn ($builder) => $builder->where('user_id', auth()->id()))
            ->where('hotness', '<', 1000)
            ->orderBy($sortField, $softOrder)
            ->paginate($perPage);
    }

    public function watchPost(User $user, Post $post): Post
    {
        $user->watchedPosts()->attach($post->id);
        $post->increment('hotness');

        return $post->fresh();
    }
}
