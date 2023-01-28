<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->nullable(false);
            $table->string('management_number')->nullable();
            $table->unsignedInteger('contract_type_id')->nullable();
            $table->unsignedInteger('residence_type_id')->nullable();
            $table->string('start_fee_payment_amount')->nullable();
            $table->unsignedInteger('start_fee_payment_method_id')->nullable();
            $table->date('start_fee_payment_date')->nullable();
            $table->unsignedInteger('start_fee_total_amount')->nullable();
            $table->text('start_fee_payment_comment')->nullable();
            $table->string('success_fee_payment_amount')->nullable();
            $table->unsignedInteger('success_fee_payment_method_id')->nullable();
            $table->date('success_fee_payment_date')->nullable();
            $table->unsignedInteger('success_fee_total_amount')->nullable();
            $table->text('success_fee_payment_comment')->nullable();
            $table->string('application_number')->nullable();
            $table->date('application_date')->nullable();
            $table->text('application_document')->nullable();
            $table->text('additional_document')->nullable();
            $table->unsignedInteger('application_status_id')->nullable();
            $table->unsignedInteger('receptionist')->nullable();
            $table->date('reception_date')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
