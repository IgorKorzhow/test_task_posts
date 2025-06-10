<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostWatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_watch_post_and_increment_hotness()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['hotness' => 0]);
        Passport::actingAs($user);

        $response = $this->postJson("/api/posts/{$post->id}/watch");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'header',
                    'content',
                    'hotness',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('watched_user_post', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->assertEquals(1, $post->fresh()->hotness);
    }

    public function test_authenticated_user_cannot_watch_same_post_twice()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['hotness' => 0]);

        Passport::actingAs($user);

        $this->postJson("/api/posts/{$post->id}/watch");
        $response = $this->postJson("/api/posts/{$post->id}/watch");

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Post already watched',
            ]);

        $this->assertEquals(1, $post->fresh()->hotness);
    }

    public function test_unauthenticated_user_cannot_watch_post()
    {
        $post = Post::factory()->create();
        $response = $this->postJson("/api/posts/{$post->id}/watch");
        $response->assertStatus(401);
    }
}
