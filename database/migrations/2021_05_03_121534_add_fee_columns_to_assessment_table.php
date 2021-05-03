<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeColumnsToAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment', function (Blueprint $table) {
            $table->string('total_assessment')->nullable();
            $table->string('clearance_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment', function (Blueprint $table) {
            $table->dropColumns(['total_assessment', 'clearance_fee']);
        });
    }
}
