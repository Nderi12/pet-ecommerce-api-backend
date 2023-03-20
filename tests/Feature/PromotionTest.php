<?php

namespace Tests\Feature;

use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PromotionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test for getting all promotions via API.
     *
     * @return void
     */
    public function testGetAllPromotions()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/main/promotions/');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a promotion via API.
     *
     * @return void
     */
    public function testPromotionCreation()
    {

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'metadata' => ['key' => 'value']
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/main/promotion/create', $data);

        $response->assertStatus(201);
    }

    /**
     * Test for updating a promotion via API.
     *
     * @return void
     */
    public function testUpdatePromotion()
    {
        $promotion = Promotion::factory()->create();

        $updatedPromotion = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'metadata' => ['key' => 'value']
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/main/promotion/' . $promotion->uuid, $updatedPromotion);

        $response->assertStatus(200);
    }

    /**
     * Test for deleting a promotion via API.
     *
     * @return void
     */
    public function testDeletePromotion()
    {
        $promotion = Promotion::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/main/promotion/' . $promotion->uuid);

        $response->assertStatus(200);
    }

    /**
     * Test for getting a single promotion via API.
     *
     * @return void
     */
    public function testGetSinglePromotion()
    {
        $promotion = Promotion::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/main/promotion/' . $promotion->uuid);

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'metadata' => ['key' => 'value']
        ];

        $response->assertStatus(200);
    }

    /**
     * Helper function to get JWT token.
     *
     * @return string
     */
    private function getJwtToken()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'super-admin@buckhill.co.uk',
            'password' => bcrypt('password')
        ]);
    
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'super-admin@buckhill.co.uk',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200);
    
        $token = $response->json('token');
    
        return $token;
    }
}
