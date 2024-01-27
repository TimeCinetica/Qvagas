<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPaycheckWrongCollumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paycheck', function (Blueprint $table) {
            //columns

           $table->string('name');
           $table->unsignedBigInteger('user_id');
           $table->string('paycheck');

           //constraint
           $table->foreign('user_id')->references('id')->on('users');
           $table->unique('user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paycheck');
    }
}
