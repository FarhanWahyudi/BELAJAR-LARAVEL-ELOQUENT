<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('DELETE FROM employees');
        DB::delete('DELETE FROM reviews');
        DB::delete('DELETE FROM customers_likes_products');
        DB::delete('DELETE FROM products');
        DB::delete('DELETE FROM categories');
        DB::delete('DELETE FROM vouchers');
        DB::delete('DELETE FROM comments');
        DB::delete('DELETE FROM virtual_accounts');
        DB::delete('DELETE FROM wallets');
        DB::delete('DELETE FROM customers');
    }
}
