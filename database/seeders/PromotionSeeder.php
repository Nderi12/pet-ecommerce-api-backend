<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = [
            [
                'title' => 'Summer Sale',
                'content' => 'Get up to 50% off on selected items in our summer sale!',
                'metadata' => json_encode(['start_date' => '2023-06-01', 'end_date' => '2023-07-31']),
            ],
            [
                'title' => 'Back to School',
                'content' => 'Get ready for the new school year with our back to school deals!',
                'metadata' => json_encode(['discount_percentage' => 20, 'minimum_purchase_amount' => 100]),
            ],
            [
                'title' => 'Holiday Special',
                'content' => 'Enjoy the holidays with our special promotions!',
                'metadata' => json_encode(['start_date' => '2023-12-01', 'end_date' => '2023-12-31', 'free_gift' => 'Holiday Mug']),
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }
    }
}
