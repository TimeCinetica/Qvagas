<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResumeCompaniesAddActualJobColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resume_companies', function (Blueprint $table) {
            $table->boolean('actualJob')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resume_companies', function (Blueprint $table) {
            $table->dropColumn(['actualJob']);
        });
    }
}
