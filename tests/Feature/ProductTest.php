<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test for getting all products via API.
     *
     * @return void
     */
    public function testGetAllProducts()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/products');

        $response->assertStatus(200);
    }
    
    /**
     * Test the creation of a product.
     *
     * @return void
     */
    public function testProductCreation()
    {
        $category = Category::factory()->create();

        $data = [
            'title' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph,
            'category_uuid' => $category->uuid,
            'metadata' => ['key' => 'value']
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/product/create', $data);

        $response->assertStatus(201);

        $product = Product::where('title', $data['title'])->first();

        $this->assertEquals($product->title, $data['title']);
        $this->assertEquals($product->price, $data['price']);
        $this->assertEquals($product->description, $data['description']);
        $this->assertEquals($product->category_uuid, $data['category_uuid']);
        $this->assertEquals($product->metadata, $data['metadata']);
    }

    /**
     * Test the updating of a product.
     *
     * @return void
     */
    public function testProductUpdate()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_uuid' => $category->uuid]);

        $data = [
            'title' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph,
            'category_uuid' => $category->uuid,
            'metadata' => ['key' => 'value']
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/product/' . $product->uuid, $data);

        $response->assertStatus(200);

        $product = $product->fresh();

        $this->assertEquals($product->title, $data['title']);
        $this->assertEquals($product->price, $data['price']);
        $this->assertEquals($product->description, $data['description']);
        $this->assertEquals($product->category_uuid, $data['category_uuid']);
        $this->assertEquals($product->metadata, $data['metadata']);
    }

    /**
     * Test the deletion of a product.
     *
     * @return void
     */
    public function testProductDeletion()
    {
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/product/' . $product->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', $product->toArray());
    }

    /**
     * Test the retrieval of a product.
     *
     * @return void
     */
    public function testGetSingleProduct()
    {
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/product/' . $product->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $product->toArray());
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
