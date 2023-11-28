<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterRolesNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->where('id', 1)->update(['name' => 'Administrador', 'description' => 'Administrador QVagas']);
        DB::table('roles')->where('id', 2)->update(['name' => 'Recursos Humanos', 'description' => 'Recursos Humanos QVagas']);
        DB::table('roles')->where('id', 3)->update(['name' => 'Candidato', 'description' => 'Usuário comum']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->where('id', 1)->update(['name' => 'sadmin', 'description' => 'Super Admin']);
        DB::table('roles')->where('id', 2)->update(['name' => 'admin', 'description' => 'Admin']);
        DB::table('roles')->where('id', 3)->update(['name' => 'user', 'description' => 'Normal user']);
    }
}
