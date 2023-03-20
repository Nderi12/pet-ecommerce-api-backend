<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

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
            'description' => 'Test Blog Description',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/main/blog/create', $blog);

        $response->assertStatus(201);
        $this->assertDatabaseHas('blogs', $blog);
    }

    /**
     * Test for updating a blog via API.
     *
     * @return void
     */
    public function testUpdateBlog()
    {
        $blog = Blog::factory()->create();

        $updatedBlog = [
            'slug' => 'updated-blog',
            'title' => 'Updated Blog',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/main/blog/' . $blog->uuid, $updatedBlog);

        $response->assertStatus(200);
        $this->assertDatabaseHas('blogs', $updatedBlog);
        $this->assertDatabaseMissing('blogs', $blog->toArray());
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
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
    
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200);
    
        $token = $response->json('token');
    
        return $token;
    }
}
