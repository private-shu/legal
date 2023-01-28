<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('tel')->nullable();
            $table->unsignedInteger('current_residence')->nullable();
            $table->string('company')->nullable();
            $table->string('related_personnel')->nullable();
            $table->text('detailed_information')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
