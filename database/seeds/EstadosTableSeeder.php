<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('estados')->insert(
         	['nombre' => 'Miranda'], 
         	['nombre' => 'Delta Amacuro'], 
         	['nombre' => 'Apure'], 
         	['nombre' => 'Barinas'], 
         	['nombre' => 'Merida'], 
         	['nombre' => 'Nueva Esparta'], 
         	['nombre' => 'Sucre'], 
         	['nombre' => 'Zulia'], 
         	['nombre' => 'Falcón'], 
         	['nombre' => 'Merida'], 
         	['nombre' => 'Tachira'],         	
         );        
    }
}
