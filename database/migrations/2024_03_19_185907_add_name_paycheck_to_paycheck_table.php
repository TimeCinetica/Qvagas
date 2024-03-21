<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamePaycheckToPaycheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paycheck', function (Blueprint $table) {
            $table->string('name_paycheck')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paycheck', function (Blueprint $table) {
            $table->dropColumn('name_paycheck');
        });
    }
}
