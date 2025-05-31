<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find('1');
        $this->assertNotNull($product);

        $category = $product->category;
        $this->assertNotNull($category);
        $this->assertEquals(1, $category->count());
        Log::info($category);
    }

    public function testElloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::get();

        $product = $product->toQuery()->where('price', 400)->get();

        $this->assertEquals(1, $product[0]->id);
    }
    
    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::get()->load('category');
        $this->assertCount(2, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }
}
