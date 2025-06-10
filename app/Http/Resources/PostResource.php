<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @mixin Post
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     required={"id", "header", "content", "hotness", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="header", type="string", example="Post header"),
 *     @OA\Property(property="content", type="string", example="Post content"),
 *     @OA\Property(property="hotness", type="integer", example=5),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-10T13:49:01.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-10T14:32:40.000000Z")
 * )
 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'header'    => $this->header,
            'content'   => $this->content,
            'hotness'   => $this->hotness,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
