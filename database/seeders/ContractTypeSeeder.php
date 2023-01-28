<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->insert([
            ['id' => 1, 'name' => '認定'],
            ['id' => 2, 'name' => '変更'],
            ['id' => 3, 'name' => '更新'],
            ['id' => 4, 'name' => '会社設立代行'],
            ['id' => 5, 'name' => '法務手続き'],
            ['id' => 6, 'name' => '税務決算'],
            ['id' => 7, 'name' => '退税業務'],
            ['id' => 8, 'name' => '理由書'],
            ['id' => 9, 'name' => '短期滞在'],
            ['id' => 10, 'name' => 'その他'],
        ]);
    }
}
