<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PostController extends Controller
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function index(PostIndexRequest $request): AnonymousResourceCollection
    {
        $conditions = $request->validated();

        $posts = $this->postRepository->getPaginatedNotWatchedAndNotOverheated($conditions);

        return PostResource::collection($posts);
    }

    public function watch(Post $post): PostResource|JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->watchedPosts()->find($post->id)) {
            return response()->json(['message' => 'Post already watched'], 400);
        }

        $post = $this->postRepository->watchPost($user, $post);

        return PostResource::make($post);
    }
}
