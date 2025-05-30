<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->customer_id = 'HANS';
        $review->product_id = '1';
        $review->rating = 5;
        $review->comment = 'bagus banget';
        $review->save();

        $review2 = new Review();
        $review2->customer_id = 'HANS';
        $review2->product_id = '2';
        $review2->rating = 3;
        $review2->comment = 'lumayan';
        $review2->save();
    }
}
