<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'food';
        $category->description = 'food desc';
        $category->is_active = true;
        $category->save();
    }
}
