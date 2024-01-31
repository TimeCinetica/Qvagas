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

           $table->string('nameUser');
           $table->unsignedBigInteger('user_id');
           $table->string('paychecking');

           //constraint
           $table->foreign('user_id')->references('id')->on('users');
           

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
