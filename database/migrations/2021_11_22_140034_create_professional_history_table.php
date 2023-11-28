<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('linkedin')->nullable();
            $table->string('lattes')->nullable();
            $table->string('video')->nullable();
            $table->string('occupationArea');
            $table->string('typeOfVacancy');
            $table->string('salary')->nullable();
            $table->integer('typeWorking');
            $table->integer('typeContract');
            $table->text('courses')->nullable();
            $table->string('firstJob')->nullable();
            $table->string('unemployedTime')->nullable();
            $table->string('laborActivity')->nullable();
            $table->string('targetJob')->nullable();
            $table->string('lastSalary')->nullable();
            $table->text('abstract')->nullable();
            $table->text('reference')->nullable();
            $table->foreignId('userId')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumes');
    }
}
