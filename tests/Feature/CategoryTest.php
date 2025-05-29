<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();
        $category->id = 'GADGET';
        $category->name = 'gadget';
        $result = $category->save();

        $this->assertTrue($result);
    }

    public function testInsertMany()
    {
        $categories = [];

        for ($i = 1; $i <= 10; $i++) {
            for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'id' => "ID: $i",
                'name' => "NAME: $i"
            ];
        }
        }

        $result = Category::insert($categories);
        $this->assertTrue($result);

        $total = Category::count();
        $this->assertEquals(10, $total);
    }
}
