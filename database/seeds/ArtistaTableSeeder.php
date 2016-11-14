<?php

use App\Artista;
use Illuminate\Database\Seeder;

class ArtistaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('artistas')->delete();

        $artistas = [
        			['nombre' => 'T-ara', 
        			 'resumen' => 'Grupo musical femenino originiario de Corea del Sur.',
        			 'imagen' => 't_ara_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

        			 ['nombre' => 'Brandon Flowers', 
        			 'resumen' => 'Cantante estadounidense, conocido por ser el líder del grupo The Killers.',
        			 'imagen' => 'bf_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

        			 ['nombre' => 'Kristína Pelaková', 
        			 'resumen' => 'Cantante originiaria de Eslovaquia.',
        			 'imagen' => 'kristina_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

        			 ];

        DB::table('artistas')->insert($artistas);
    }
}
