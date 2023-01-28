<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<100; $i++) {
            DB::table('contracts')->insert([
                [
                    'member_id' => 1,
                    'management_number' => "H-" . $i,
                    'contract_type_id' => 1,
                    'residence_type_id' => 1,
                    'start_fee_payment_amount' => $i,
                    'start_fee_payment_method_id' => $i,
                    'start_fee_payment_date' => date("Y-m-d"),
                    'start_fee_total_amount' => $i,
                    'start_fee_payment_comment' => "着手金テストコメント" . $i,
                    'success_fee_payment_amount' => $i,
                    'success_fee_payment_method_id' => 1,
                    'success_fee_payment_date' => date("Y-m-d"),
                    'success_fee_total_amount' => $i,
                    'success_fee_payment_comment' => "成功金テストコメント" . $i,
                    'application_number' => "Z-" . $i,
                    'application_date' => date("Y-m-d"),
                    'application_document' => "申請書類テスト" . $i,
                    'additional_document' => "追加資料テスト" . $i,
                    'application_status_id' => 1,
                    'receptionist' => 1,
                    'reception_date' => date("Y-m-d"),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            ]);
        }

        for ($i=1; $i<100; $i++) {
            DB::table('contracts')->insert([
                [
                    'member_id' => 2,
                    'management_number' => "z-" . $i,
                    'contract_type_id' => 2,
                    'residence_type_id' => 2,
                    'start_fee_payment_amount' => $i,
                    'start_fee_payment_method_id' => $i,
                    'start_fee_payment_date' => date("Y-m-d"),
                    'start_fee_total_amount' => $i,
                    'start_fee_payment_comment' => "着手金テストコメント" . $i,
                    'success_fee_payment_amount' => $i,
                    'success_fee_payment_method_id' => 1,
                    'success_fee_payment_date' => date("Y-m-d"),
                    'success_fee_total_amount' => $i,
                    'success_fee_payment_comment' => "成功金テストコメント" . $i,
                    'application_number' => "Z-" . $i,
                    'application_date' => date("Y-m-d"),
                    'application_document' => "申請書類テスト" . $i,
                    'additional_document' => "追加資料テスト" . $i,
                    'application_status_id' => 2,
                    'receptionist' => 1,
                    'reception_date' => date("Y-m-d"),
                    'created_by' => 2,
                    'updated_by' => 2,
                ]
            ]);
        }
    }
}
