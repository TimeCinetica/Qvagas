<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddStateId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('stateId')->nullable()->constrained('states');
            $table->foreignId('rgStateId')->nullable()->constrained('states');

            $table->string('state')->nullable()->change();
            $table->string('rgState')->nullable()->change();
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
            $table->dropForeign(['stateId']);
            $table->dropForeign(['rgStateId']);
            $table->dropColumn(['stateId']);
            $table->dropColumn(['rgStateId']);

            $table->string('state')->nullable(false)->change();
            $table->string('rgState')->nullable(false)->change();
        });
    }
}
