<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test for getting all blogs via API.
     *
     * @return void
     */
    public function testGetAllBlogs()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/main/blogs');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a blog via API.
     *
     * @return void
     */
    public function testCreateBlog()
    {
        $blog = [
            'slug' => 'test-blog',
            'title' => 'Test Blog',
            'content' => 'Test Blog Content',
            'metadata' => ['key' => 'value']
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/main/blog/create', $blog);

        $response->assertStatus(201);
    }

    /**
     * Test for deleting a blog via API.
     *
     * @return void
     */
    public function testDeleteBlog()
    {
        $blog = Blog::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/main/blog/' . $blog->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('blogs', $blog->toArray());
    }

    /**
     * Test for getting a single blog via API.
     *
     * @return void
     */
    public function testGetSingleBlog()
    {
        $blog = Blog::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/main/blog/' . $blog->uuid);

        $blog = [
            'slug' => $blog->slug,
            'title' => $blog->title,
        ];

        $response->assertStatus(200);
        $this->assertDatabaseHas('blogs', $blog);
    }

    /**
     * Helper function to get JWT token.
     *
     * @return string
     */
    private function getJwtToken()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'super-admin@demo.co.uk',
            'password' => bcrypt('password')
        ]);
    
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'super-admin@demo.co.uk',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200);
    
        $token = $response->json('token');
    
        return $token;
    }
}
