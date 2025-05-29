<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreateVoucher()
    {
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->voucher_code = '849032780';
        $voucher->save();

        $this->assertNotNull($voucher->id);
    }

    public function testCreateVoucherUUID()
    {
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->save();

        $this->assertNotNull($voucher->voucher_code);
    }

    public function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', '=', 'sample voucher')->first();
        $voucher->delete();

        $voucher = Voucher::where('name', '=', 'sample voucher')->first();
        $this->assertNull($voucher);

        $voucher = Voucher::withTrashed()->where('name', '=', 'sample voucher')->first();
        $this->assertNotNull($voucher);
    }
}
