<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('cedula')->nullable();
            $table->string('brgy_fee')->nullable();
            $table->string('bfp_fee')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('type')->nullable();
            $table->text('path')->nullable();
            $table->text('directory')->nullable();
            $table->string('filename')->nullable();
            $table->string('original_name')->nullable();
            $table->string('source')->default("file")->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('assessment');
    }
}
