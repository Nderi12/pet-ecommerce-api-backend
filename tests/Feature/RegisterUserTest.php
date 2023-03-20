<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUserCanBeRegistered()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
            'address' => '123 Main St',
            'phone_number' => '555-555-5555',
            'is_marketing' => true,
            'last_logged_in' => now(),
        ];

        $response = $this->post('/api/v1/admin/register', $userData);

        $response->assertStatus(200);
    }
}
