<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testUserCanLogin()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'admin7@buckhill.co.uk',
            'password' => bcrypt('password')
        ]);
    
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => 'admin7@buckhill.co.uk',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200);
    }
}
