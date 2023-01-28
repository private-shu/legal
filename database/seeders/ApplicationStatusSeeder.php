<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('application_statuses')->insert([
            ['id' => 1, 'name' => '許可'],
            ['id' => 2, 'name' => '不許可'],
            ['id' => 3, 'name' => '申請中'],
            ['id' => 4, 'name' => '再申請'],
            ['id' => 5, 'name' => '完了'],
        ]);
    }
}
