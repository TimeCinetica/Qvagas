<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'          => 'Super Admin',
            'email'         => 'sadmin@qvagas.com.br',
            'password'      => bcrypt('secretPassword#123'),
            'roleId'        => Role::SuperAdmin,
            'created_at'    => now(),
            'updated_at'    => now(),
            'cpf'           => '11111111111',
            'birthDate'     => now(),
            'cellphone'     => 'sadmin',
            'schooling'     => 'sadmin',
            'cep'           => '29111111',
            'address'       => 'admin',
            'number'        => '123',
            'district'      => 'sadmin',
            'sex'           => 3,
            'rg'            => 'sadmin',
            'mother'        => 'sadmin',
            'civil'         => 0,
            'volunteerWork' => 1,
            'hasChildren'   => 0,
            'availableTravel' => 1
        ]);
    }
}
