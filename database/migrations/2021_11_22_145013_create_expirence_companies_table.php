<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpirenceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resumeId')->constrained('resumes');
            $table->string('companyName')->nullable();
            $table->text('companyActivity')->nullable();
            $table->date('companyStart')->nullable();
            $table->date('companyEnd')->nullable();
            $table->string('companyLeftReason')->nullable();
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
        Schema::dropIfExists('resume_companies');
    }
}
