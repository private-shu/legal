<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ResidenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('residence_types')->insert([
            ['id' => 1, 'name' => '教授', 'category' => 1],
            ['id' => 2, 'name' => '芸術', 'category' => 1],
            ['id' => 3, 'name' => '宗教', 'category' => 1],
            ['id' => 4, 'name' => '報道', 'category' => 1],
            ['id' => 5, 'name' => '高度専門職', 'category' => 1],
            ['id' => 6, 'name' => '経営・管理', 'category' => 1],
            ['id' => 7, 'name' => '法律・会計業務', 'category' => 1],
            ['id' => 8, 'name' => '医療', 'category' => 1],
            ['id' => 9, 'name' => '研究', 'category' => 1],
            ['id' => 10, 'name' => '教育', 'category' => 1],
            ['id' => 11, 'name' => '技術・人文知識・国際業務', 'category' => 1],
            ['id' => 12, 'name' => '企業内転勤', 'category' => 1],
            ['id' => 13, 'name' => '介護', 'category' => 1],
            ['id' => 14, 'name' => '興行', 'category' => 1],
            ['id' => 15, 'name' => '技能', 'category' => 1],
            ['id' => 16, 'name' => '特定技能', 'category' => 1],
            ['id' => 17, 'name' => '技能実習', 'category' => 1],
            ['id' => 18, 'name' => '文化活動', 'category' => 1],
            ['id' => 19, 'name' => '短期滞在', 'category' => 1],
            ['id' => 20, 'name' => '留学', 'category' => 1],
            ['id' => 21, 'name' => '研修', 'category' => 1],
            ['id' => 22, 'name' => '家族滞在', 'category' => 1],
            ['id' => 23, 'name' => '特定活動', 'category' => 1],
            ['id' => 24, 'name' => '永住者', 'category' => 1],
            ['id' => 25, 'name' => '日本人の配偶者等', 'category' => 1],
            ['id' => 26, 'name' => '永住者の配偶者等', 'category' => 1],
            ['id' => 27, 'name' => '定住者', 'category' => 1],
            ['id' => 28, 'name' => '日本籍', 'category' => 2],
            ['id' => 29, 'name' => '旅游签证', 'category' => 3],
            ['id' => 30, 'name' => '探亲访友', 'category' => 3],
            ['id' => 31, 'name' => '商务考察', 'category' => 3],
            ['id' => 32, 'name' => '无', 'category' => 4],
        ]);
    }
}
