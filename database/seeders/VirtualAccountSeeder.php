<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::where('customer_id', 'HANS')->firstOrFail();

        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = 'mandiri';
        $virtualAccount->va_number = '1235438290';
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}
