<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        if (Schema::hasTable('races')) {
            DB::table('races')->insert([
                [
                    'name' => 'Branco',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Preto',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Pardo',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Amarelo',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Indígena',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('races');
    }
}
