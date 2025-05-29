<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Scopes\isActiveScope;
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

        $total = Category::withoutGlobalScopes([isActiveScope::class])->count();
        $this->assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::withoutGlobalScopes([isActiveScope::class])->find('FOOD');

        $this->assertNotNull($category);
        $this->assertEquals($category->id, 'FOOD');
        $this->assertEquals($category->name, 'food');
        $this->assertEquals($category->description, 'food desc');
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::withoutGlobalScopes([isActiveScope::class])->find('FOOD');
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

        $result = Category::withoutGlobalScopes([isActiveScope::class])->whereNull('description')->get();
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

        Category::withoutGlobalScopes([isActiveScope::class])->whereNull('description')->update([
            'description' => 'updated'
        ]);
        $total = Category::withoutGlobalScopes([isActiveScope::class])->where('description', '=', 'updated')->count();
        $this->assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::withoutGlobalScopes([isActiveScope::class])->find('FOOD');
        $result = $category->delete();

        $this->assertTrue($result);

        $total = Category::withoutGlobalScopes([isActiveScope::class])->count();
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
        $total = Category::withoutGlobalScopes([isActiveScope::class])->count();
        $this->assertEquals(10, $total);

        Category::withoutGlobalScopes([isActiveScope::class])->whereNull('description')->delete();
        $total = Category::withoutGlobalScopes([isActiveScope::class])->count();
        $this->assertEquals(0, $total);
    }

    public function testCreate()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'food',
            'description' => 'food category'
        ];

        $category = new Category($request);
        $category->save();

        $this->assertNotNull($category);
    }

    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            'name' => 'food updated',
            'description' => 'food category updated'
        ];

        $category = Category::withoutGlobalScopes([isActiveScope::class])->find('food');
        $category->fill($request);
        $category->update();

        $this->assertNotNull($category->name);
    }

    public function testGlobalScope()
    {
        Category::create([
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'food category',
            'is_active' => false,
        ]);

        $category = Category::find('FOOD');
        $this->assertNull($category);

        $category = Category::withoutGlobalScopes([isActiveScope::class])->find('FOOD');
        $this->assertNotNull($category);
    }
}
