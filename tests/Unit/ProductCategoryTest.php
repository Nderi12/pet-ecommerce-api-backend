<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductCategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testProductCategoryRelationship()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_uuid' => $category->uuid,
        ]);

        $this->assertEquals($category->uuid, $product->category->uuid);
    }
}
