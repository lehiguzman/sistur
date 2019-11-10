<?php

use Illuminate\Database\Seeder;

class RamasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ramas')->insert([
            'titulo' => 'Otros',
            'descripcion' => NULL            
        ]);
    }
}
