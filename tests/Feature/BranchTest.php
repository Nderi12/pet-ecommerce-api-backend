<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for getting all brands via API.
     *
     * @return void
     */
    public function testGetAllBrands()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/brands');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a brand via API.
     *
     * @return void
     */
    public function testCreateBrand()
    {
        $brand = [
            'slug' => 'test-brand',
            'title' => 'Test Brand',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/brand/create', $brand);

        $response->assertStatus(201);
        $this->assertDatabaseHas('brands', $brand);
    }

    /**
     * Test for updating a brand via API.
     *
     * @return void
     */
    public function testUpdateBrand()
    {
        $brand = Brand::factory()->create();

        $updatedBrand = [
            'slug' => 'updated-brand',
            'title' => 'Updated Brand',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/brand/' . $brand->uuid, $updatedBrand);

        $response->assertStatus(200);
        $this->assertDatabaseHas('brands', $updatedBrand);
        $this->assertDatabaseMissing('brands', $brand->toArray());
    }

    /**
     * Test for deleting a brand via API.
     *
     * @return void
     */
    public function testDeleteBrand()
    {
        $brand = Brand::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/brand/' . $brand->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('brands', $brand->toArray());
    }

    /**
     * Test for getting a single brand via API.
     *
     * @return void
     */
    public function testGetSingleBrand()
    {
        $brand = Brand::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/brand/' . $brand->uuid);

        $brand = [
            'slug' => $brand->slug,
            'title' => $brand->title,
        ];

        $response->assertStatus(200);
        $this->assertDatabaseHas('brands', $brand);
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
