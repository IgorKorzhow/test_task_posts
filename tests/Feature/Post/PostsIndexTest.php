<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostsIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_get_paginated_posts()
    {
        $user = User::factory()->create();
        Post::factory()->count(30)->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'header',
                    'content',
                    'hotness',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
        ]);
        $this->assertCount(15, $response->json('data'));
    }

    public function test_unauthenticated_user_cannot_get_posts()
    {
        $response = $this->getJson('/api/posts');
        $response->assertStatus(401);
    }
}
