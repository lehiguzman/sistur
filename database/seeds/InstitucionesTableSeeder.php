<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitucionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instituciones')->insert([
            'nombre' => 'Admin',
            'telefono' => '91919191919',
            'direccion' => 'no aplica',
            'tipo_id' => 1,
            'rama_id' => 1,
            'estado_id' => 1,            
        ]);
    }
}
