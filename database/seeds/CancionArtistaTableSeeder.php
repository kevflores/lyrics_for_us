<?php

use Illuminate\Database\Seeder;

class CancionArtistaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                $cancionesArtistas = [
        			
                     ['cancion_id' => 1, 
                     'artista_id' => 4,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],
        			
                     ['cancion_id' => 5, 
                     'artista_id' => 16,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['cancion_id' => 6, 
                     'artista_id' => 25,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['cancion_id' => 2, 
                     'artista_id' => 15,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['cancion_id' => 7, 
                     'artista_id' => 7,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['cancion_id' => 3, 
                     'artista_id' => 13,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['cancion_id' => 4, 
                     'artista_id' => 9,
                     'invitado' => FALSE,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],
                     
        			 ];

        DB::table('canciones_artistas')->insert($cancionesArtistas);
    }
}
