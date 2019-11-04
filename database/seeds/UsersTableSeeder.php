<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'nombre' => 'Admin',
            'num_documento' => '91919191919',
            'direccion' => 'no aplica',
            'telefono' => '0000000000',
            'condicion' => 1,
            'rol' => 1,
            'imagen' => NULL,
            'institucion_id' => 5,
        	'email' => 'admin@correo.com',
        	'password' => bcrypt('admin')
        ]);
    }
}
