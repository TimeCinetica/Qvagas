<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterResumeStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resume_statuses')
            ->where('id', 12)
            ->update([
                'name' => 'Entrevista com Recrutador'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resume_statuses')
            ->where('id', 12)
            ->update([
                'name' => 'Testes e Questionário'
            ]);
    }
}
