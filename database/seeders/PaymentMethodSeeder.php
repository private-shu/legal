<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            ['id' => 1, 'name' => '银行送金'],
            ['id' => 2, 'name' => '现金'],
            ['id' => 3, 'name' => 'paypay'],
            ['id' => 4, 'name' => '国内rmb'],
        ]);
    }
}
