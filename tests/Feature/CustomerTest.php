<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testQueryOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find('HANS');
        $this->assertNotNull($customer);

        $wallet = $customer->wallet;
        $this->assertEquals(1000000, $wallet->amount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = 'Hns';
        $customer->name = 'farhan';
        $customer->email = 'farhan@gmail.com';
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        $this->assertEquals($customer->id, $wallet->customer_id);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find('HANS');
        $virtualAccount = $customer->virtualAccount;

        $this->assertEquals('mandiri', $virtualAccount->bank);
    }

    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find('HANS');
        $customer->likeProduct()->attach('2');

        $products = $customer->likeProduct;
        $this->assertEquals(2, $products[0]->id);
    }

    public function testManyToManyDetach()
    {
        $this->testManyToMany();

        $customer = Customer::find('HANS');
        $customer->likeProduct()->detach('2');

        $product = $customer->likeProduct;

        $this->assertCount(0, $product);
    }

    public function testPivoteAttribute()
    {
        $this->testManyToMany();

        $customer = Customer::find('HANS');
        $products = $customer->likeProduct;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            $this->assertNotNull($pivot->customer_id);
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);
        }
    }

    public function testPivoteAttributeCondition()
    {
        $this->testManyToMany();

        $customer = Customer::find('HANS');
        $products = $customer->likeProductLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            $this->assertNotNull($pivot->customer_id);
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);
        }
    }

    public function testPivoteModel()
    {
        $this->testManyToMany();

        $customer = Customer::find('HANS');
        $products = $customer->likeProductLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            $this->assertNotNull($pivot->customer_id);
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);

            $this->assertNotNull($pivot->customer);
            $this->assertNotNull($pivot->product);
        }
    }
}
