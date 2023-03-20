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
        ])->get('/api/v1/main/promotions');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a promotion via API.
     *
     * @return void
     */
    public function testProductCreation()
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

        $promotion = Promotion::where('title', $data['title'])->first();

        $this->assertEquals($promotion->title, $data['title']);
        $this->assertEquals($promotion->content, $data['content']);
        $this->assertEquals($promotion->metadata, $data['metadata']);
    }

    /**
     * Test for updating a promotion via API.
     *
     * @return void
     */
    // public function testUpdatePromotion()
    // {
    //     $promotion = Promotion::factory()->create();

    //     $updatedPromotion = [
    //         'title' => $this->faker->sentence,
    //         'content' => $this->faker->paragraph,
    //         'metadata' => ['key' => 'value']
    //     ];

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $this->getJwtToken(),
    //     ])->put('/api/v1/main/promotion/' . $promotion->uuid, $updatedPromotion);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('promotions', $updatedPromotion);
    //     $this->assertDatabaseMissing('promotions', $promotion->toArray());
    // }

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
        $this->assertDatabaseMissing('promotions', $promotion->toArray());
    }

    // /**
    //  * Test for getting a single promotion via API.
    //  *
    //  * @return void
    //  */
    // public function testGetSinglePromotion()
    // {
    //     $promotion = Promotion::factory()->create();

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $this->getJwtToken(),
    //     ])->get('/api/v1/main/promotion/' . $promotion->uuid);

    //     $promotion = [
    //         'content' => $promotion->content,
    //         'title' => $promotion->title,
    //     ];

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('promotions', $promotion);
    // }

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
