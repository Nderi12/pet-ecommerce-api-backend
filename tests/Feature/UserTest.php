<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test for getting all users via API.
     *
     * @return void
     */
    public function testGetAllUsers()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->get('/api/v1/admin/user-listing');

        $response->assertStatus(200);
    }

    /**
     * Test for updating a user via API.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $users = User::factory()->create();

        $updatedUser = [
            // 'slug' => 'updated-users',
            // 'title' => 'Updated Category',
            'name' => 'Updated name',
            'email' => $this->faker->email(),
            'address' => 'Updated address',
            'phone_number' => '254788991122',
            'password' => bcrypt('password'),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->put('/api/v1/admin/user-edit/' . $users->uuid, $updatedUser);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $updatedUser);
        $this->assertDatabaseMissing('users', $users->toArray());
    }

    /**
     * Test for deleting a user via API.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ])->delete('/api/v1/admin/user-delete/' . $user->uuid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', $user->toArray());
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
