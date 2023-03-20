<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $user = User::create([
                'name' => 'Admin user',
                'email' => 'admin1@buckhill.co.uk',
                'phone_number' => '254722890101',
                'address' => 'This is a sample address',
                'email_verified_at' => now(),
                'password' => Hash::make('userpassword'),
            ]);
        });
    }
}
