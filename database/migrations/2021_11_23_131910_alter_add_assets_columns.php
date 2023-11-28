<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddAssetsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable();
        });

        Schema::table('resumes', function (Blueprint $table) {
            $table->string('resumePhoto')->nullable();
            $table->string('recomendationPhoto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo']);
        });

        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['resumePhoto']);
            $table->dropColumn(['recomendationPhoto']);
        });
    }
}
