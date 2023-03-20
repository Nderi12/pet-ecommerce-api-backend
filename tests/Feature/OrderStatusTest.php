<?php

namespace Tests\Feature;

use App\Models\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for getting all order statuses via API.
     *
     * @return void
     */
    public function testGetAllOrderStatuses()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/order-statuses');

        $response->assertStatus(200);
    }

    /**
     * Test for creating a order status via API.
     *
     * @return void
     */
    public function testCreateOrderStatus()
    {
        $orderStatus = [
            'title' => 'Test order status',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->post('/api/v1/order-status/create', $orderStatus);

        $response->assertStatus(201);
        $this->assertDatabaseHas('order_statuses', $orderStatus);
    }

    /**
     * Test for updating a orderStatus via API.
     *
     * @return void
     */
    public function testUpdateOrderStatus()
    {
        $orderStatus = OrderStatus::factory()->create();

        $updatedOrderStatus = [
            'title' => 'Updated Order Status',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/order-status/' . $orderStatus->uuid, $updatedOrderStatus);

        $response->assertStatus(200);
        $this->assertDatabaseHas('order_statuses', $updatedOrderStatus);
        $this->assertDatabaseMissing('order_statuses', $orderStatus->toArray());
    }

    /**
     * Test for deleting a order status via API.
     *
     * @return void
     */
    public function testDeleteOrderStatus()
    {
        $orderStatus = OrderStatus::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/order-status/' . $orderStatus->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('order_statuses', $orderStatus->toArray());
    }

    /**
     * Test for getting a single order status via API.
     *
     * @return void
     */
    public function testGetSingleOrderStatus()
    {
        $orderStatus = OrderStatus::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/order-status/' . $orderStatus->uuid);

        $orderStatus = [
            'title' => $orderStatus->title,
        ];

        $response->assertStatus(200);
        $this->assertDatabaseHas('order_statuses', $orderStatus);
    }

    // /**
    //  * Helper function to get JWT token.
    //  *
    //  * @return string
    //  */
    private function getJwtToken()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'admin8@buckhill.co.uk',
            'password' => bcrypt('password')
        ]);
    
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'admin8@buckhill.co.uk',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200);
    
        $token = $response->json('token');
    
        return $token;
    }
}
