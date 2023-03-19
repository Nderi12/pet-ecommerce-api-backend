<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['title' => 'Active'],
            ['title' => 'Pending'],
            ['title' => 'Completed'],
            ['title' => 'Cancelled'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }   //
    }
}
