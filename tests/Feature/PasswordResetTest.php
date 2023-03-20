<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_resetPasswordResetTest_password()
    {
        $user = User::factory()->create();

        $token = $this->getJwtToken($user->id);
        
        $response = $this->postJson('/api/v1/admin/reset-password-token', [
            'email' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Password reset successfully.',
        ]);
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
