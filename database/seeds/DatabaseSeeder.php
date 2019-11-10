<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([        	
        	EstadosTableSeeder::class,
        	RamasTableSeeder::class,
        	TiposTableSeeder::class,
        	InstitucionesTableSeeder::class,
        	UsersTableSeeder::class,
        ]);
    }
}
