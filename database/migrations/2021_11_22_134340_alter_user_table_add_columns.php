<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lastName']);
            $table->date('birthDate');
            $table->string('cellphone')->unique();
            $table->string('cellphone2')->nullable();
            $table->string('schooling');
            $table->string('cep');
            $table->string('address');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->integer('sex');
            $table->string('otherSex')->nullable();
            $table->string('rg');
            $table->string('rgState');
            $table->string('father');
            $table->string('mother');
            $table->integer('civil');
            $table->string('otherCivil')->nullable();
            $table->boolean('volunteerWork');
            $table->string('otherVolunteerWork')->nullable();
            $table->integer('hasChildren');
            $table->string('otherHasChildren')->nullable();
            $table->string('whoHelps')->nullable();
            $table->string('accident')->nullable();
            $table->string('smoke')->nullable();
            $table->string('timeAvailability')->nullable();
            $table->string('workWeekends')->nullable();
            $table->string('missWork')->nullable();
            $table->text('hobbies')->nullable();
            $table->boolean('availableTravel');
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
            $table->string('lastName');
            $table->dropColumn(['birthDate']);
            $table->dropColumn(['cellphone']);
            $table->dropColumn(['cellphone2']);
            $table->dropColumn(['cep']);
            $table->dropColumn(['schooling']);
            $table->dropColumn(['address']);
            $table->dropColumn(['number']);
            $table->dropColumn(['district']);
            $table->dropColumn(['city']);
            $table->dropColumn(['state']);
            $table->dropColumn(['sex']);
            $table->dropColumn(['otherSex']);
            $table->dropColumn(['rg']);
            $table->dropColumn(['rgState']);
            $table->dropColumn(['father']);
            $table->dropColumn(['mother']);
            $table->dropColumn(['civil']);
            $table->dropColumn(['otherCivil']);
            $table->dropColumn(['volunteerWork']);
            $table->dropColumn(['otherVolunteerWork']);
            $table->dropColumn(['hasChildren']);
            $table->dropColumn(['otherHasChildren']);
            $table->dropColumn(['whoHelps']);
            $table->dropColumn(['accident']);
            $table->dropColumn(['smoke']);
            $table->dropColumn(['timeAvailability']);
            $table->dropColumn(['workWeekends']);
            $table->dropColumn(['missWork']);
            $table->dropColumn(['hobbies']);
            $table->dropColumn(['availableTravel']);
        });
    }
}
