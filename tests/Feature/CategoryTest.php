<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for getting all categories via API.
     *
     * @return void
     */
    public function testGetAllCategories()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/categories');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a category via API.
     *
     * @return void
     */
    public function testCreateCategory()
    {
        $category = [
            'slug' => 'test-category',
            'title' => 'Test Category',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/category/create', $category);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }

    /**
     * Test for updating a category via API.
     *
     * @return void
     */
    public function testUpdateCategory()
    {
        $category = Category::factory()->create();

        $updatedCategory = [
            'slug' => 'updated-category',
            'title' => 'Updated Category',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/category/' . $category->uuid, $updatedCategory);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $updatedCategory);
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    /**
     * Test for deleting a category via API.
     *
     * @return void
     */
    public function testDeleteCategory()
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/category/' . $category->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    /**
     * Test for getting a single category via API.
     *
     * @return void
     */
    public function testGetSingleCategory()
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/category/' . $category->uuid);

        $category = [
            'slug' => $category->slug,
            'title' => $category->title,
        ];

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $category);
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
