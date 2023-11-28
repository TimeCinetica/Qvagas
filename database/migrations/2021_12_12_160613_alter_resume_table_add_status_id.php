<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResumeTableAddStatusId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('resume_statuses')) {
            Schema::rename('resume_status', 'resume_statuses');
        }

        Schema::table('resumes', function (Blueprint $table) {
            $table->unsignedBigInteger('statusId')->default(1);
            $table->foreign('statusId')->references('id')->on('resume_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropForeign(['statusId']);
            $table->dropColumn(['statusId']);
        });

        Schema::rename('resume_statuses', 'resume_status');
    }
}
