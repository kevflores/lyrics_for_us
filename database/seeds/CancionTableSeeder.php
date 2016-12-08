<?php

use Illuminate\Database\Seeder;

class CancionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canciones = [
        			
                     ['titulo' => 'Tailor Made', 
                     'resumen' => 'Canción perteneciente al primer álbum de estudio de la cantante.',
                     'disco_id' => NULL,
                     'autor' => 'Colbie Caillat, Jason Reeves',
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Tú Eres Para Mí', 
                     'resumen' => 'Canción cristiana.',
                     'disco_id' => 9,
                     'autor' => NULL,
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Brave Heart', 
                     'resumen' => 'Canción número 8 del álbum.',
                     'disco_id' => 7,
                     'autor' => 'Hilary Duff',
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Bloom', 
                     'resumen' => 'Primer single del mini-álbum.',
                     'disco_id' => 15,
                     'autor' => 'Son Ga In',
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'You (English Ver.)', 
                     'resumen' => 'Versión en inglés de la canción "You".',
                     'disco_id' => 22,
                     'autor' => 'James Lee',
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'A Sorta Fairytale', 
                     'resumen' => 'Primer sencillo del álbum.',
                     'disco_id' => 4,
                     'autor' => 'Tori Amos',
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Love Effect', 
                     'resumen' => 'Canción número 3.',
                     'disco_id' => 20,
                     'autor' => NULL,
                     'audio' => NULL,
                     'portada' => NULL,
                     'letra' => NULL,
                     'fecha_letra' => NULL,
                     'usuario_id' => NULL,
                     'fecha_letra_modificada' => NULL,
                     'usuario_modificador_id' => NULL,
                     'visitas' => 0,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

        			 ];

        DB::table('canciones')->insert($canciones);
    }
}
