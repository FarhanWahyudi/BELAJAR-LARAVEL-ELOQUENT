<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
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

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FOOD');

        $this->assertNotNull($category);
        $this->assertEquals($category->id, 'FOOD');
        $this->assertEquals($category->name, 'food');
        $this->assertEquals($category->description, 'food desc');
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FOOD');
        $category->name = 'food updated';

        $result = $category->update();
        $this->assertTrue($result);
    }

    public function testSelect()
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

        Category::insert($categories);

        $result = Category::whereNull('description')->get();
        $this->assertEquals(10, $result->count());
        $result->each(function ($category) {
            $this->assertNull($category->description);

            $category->description = 'updated';
            $category->update();
        });
    }

    public function testUpdateMany()
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

        Category::insert($categories);

        Category::whereNull('description')->update([
            'description' => 'updated'
        ]);
        $total = Category::where('description', '=', 'updated')->count();
        $this->assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FOOD');
        $result = $category->delete();

        $this->assertTrue($result);

        $total = Category::count();
        $this->assertEquals(0, $total);
    }

    public function testDeleteMany()
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

        Category::insert($categories);
        $total = Category::count();
        $this->assertEquals(10, $total);

        Category::whereNull('description')->delete();
        $total = Category::count();
        $this->assertEquals(0, $total);
    }
}
