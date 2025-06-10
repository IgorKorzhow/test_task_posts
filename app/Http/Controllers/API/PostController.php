<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints for Posts"
 * )
 */
class PostController extends Controller
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get paginated list of posts",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="sort_field",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string", enum={"id","header","content","hotness","created_at","updated_at"})
     *     ),
     *     @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order (asc or desc)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc","desc"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of posts",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Post")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index(PostIndexRequest $request)
    {
        $conditions = $request->validated();

        $posts = $this->postRepository->getPaginatedNotWatchedAndNotOverheated($conditions);

        return PostResource::collection($posts);
    }

    /**
     * @OA\Post(
     *     path="/api/posts/{post}/watch",
     *     summary="Mark post as watched and increment hotness",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="ID of the post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post watched",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Post")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function watch(Post $post)
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
