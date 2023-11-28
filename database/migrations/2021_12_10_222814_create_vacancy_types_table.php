<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVacancyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vacancy_types')) {
            Schema::create('vacancy_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });

            DB::table('vacancy_types')->insert([
                ['name' => 'Primeiro Emprego', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'PCD - Pessoa com deficiência', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Estágio', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Vaga de Emprego', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        Schema::table('resumes', function (Blueprint $table) {
            if (Schema::hasColumn('resumes', 'typeOfVacancy')) {
                $table->dropColumn(['typeOfVacancy']);
            }

            if (!Schema::hasColumn('resumes', 'vacancyTypeId')) {
                $table->unsignedBigInteger('vacancyTypeId')->default(1);
            }

            $table->foreign('vacancyTypeId')->references('id')->on('vacancy_types');
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
            $table->dropForeign(['vacancyTypeId']);
            $table->dropColumn(['vacancyTypeId']);
            $table->string('typeOfVacancy');
        });

        Schema::dropIfExists('vacancy_types');
    }
}
