<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_id')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_scope')->nullable();
            $table->string('business_line')->nullable();
            $table->string('business_number')->nullable();
            $table->string('bn_number')->nullable();
            $table->string('dominant_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('location')->nullable();
            $table->string('geo_long')->nullable();
            $table->string('geo_lat')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('capitalization')->nullable();
            $table->string('line_of_business')->nullable();
            $table->string('no_of_employee')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('pagibig_no')->nullable();
            $table->string('tin_no')->nullable();
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
        Schema::dropIfExists('business');
    }
}
