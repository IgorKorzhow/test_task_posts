<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
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
