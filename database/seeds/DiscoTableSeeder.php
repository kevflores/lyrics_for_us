<?php

use Illuminate\Database\Seeder;

class DiscoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discos = [
        			
                     ['titulo' => 'Unlocked', 
                     'resumen' => 'Segundo álbum de estudio.',
                     'fecha' => '2012-02-15',
                     'portada' => NULL,
                     'artista_id' => 21,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Mine (3rd Single)', 
                     'resumen' => 'Tercer sencillo de la cantante japonesa',
                     'fecha' => '2013-05-08',
                     'portada' => NULL,
                     'artista_id' => 19,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Sweet Rendezvous', 
                     'resumen' => 'Primer mini-álbum.',
                     'fecha' => '2012-03-08',
                     'portada' => NULL,
                     'artista_id' => 27,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Scarlet\'s Walk', 
                     'resumen' => 'Séptimo álbum de estudio.',
                     'fecha' => '2002-10-28',
                     'portada' => NULL,
                     'artista_id' => 25,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Catch Me', 
                     'resumen' => 'Sexto álbum de estudio.',
                     'fecha' => '2012-09-24',
                     'portada' => NULL,
                     'artista_id' => 3,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'DRAMA', 
                     'resumen' => 'Tercer mini-álbum.',
                     'fecha' => '2014-01-23',
                     'portada' => NULL,
                     'artista_id' => 27,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Breathe In. Breathe Out.', 
                     'resumen' => 'Quinto álbum de estudio.',
                     'fecha' => '2015-06-16',
                     'portada' => NULL,
                     'artista_id' => 13,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Los Buenos Días', 
                     'resumen' => 'Quinto álbum de estudio.',
                     'fecha' => '2008-05-19',
                     'portada' => NULL,
                     'artista_id' => 26,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Le Canto', 
                     'resumen' => 'Este álbum es la versión en español del álbum "Kari Jobe".',
                     'fecha' => '2009-04-28',
                     'portada' => NULL,
                     'artista_id' => 15,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Restored', 
                     'resumen' => 'Cuarto álbum de estudio',
                     'fecha' => '2004-11-16',
                     'portada' => NULL,
                     'artista_id' => 12,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Metamorphosis', 
                     'resumen' => 'Segundo álbum de estudio.',
                     'fecha' => '2003-08-26',
                     'portada' => NULL,
                     'artista_id' => 13,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Unspoken', 
                     'resumen' => 'Primer álbum de estudio',
                     'fecha' => '2014-04-01',
                     'portada' => NULL,
                     'artista_id' => 18,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Are You Happy?', 
                     'resumen' => 'Decimoquinto álbum de estudio.',
                     'fecha' => '2016-10-26',
                     'portada' => NULL,
                     'artista_id' => 8,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Follow Through', 
                     'resumen' => 'Segundo álbum de estudio.',
                     'fecha' => '2016-08-26',
                     'portada' => NULL,
                     'artista_id' => 18,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Talk About S.', 
                     'resumen' => 'Segundo mini-álbum.',
                     'fecha' => '2012-10-05',
                     'portada' => NULL,
                     'artista_id' => 9,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Loose', 
                     'resumen' => 'Tercer álbum de estudio.',
                     'fecha' => '2006-06-06',
                     'portada' => NULL,
                     'artista_id' => 2,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Perspectiva', 
                     'resumen' => 'Primer álbum del cantante argentino.',
                     'fecha' => '2014-01-01',
                     'portada' => NULL,
                     'artista_id' => 20,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'MAGAZINE', 
                     'resumen' => 'Primer álbum de estudio.',
                     'fecha' => '2011-01-26',
                     'portada' => NULL,
                     'artista_id' => 21,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'REMEMBER', 
                     'resumen' => 'Octavo mini-álbum.',
                     'fecha' => '2016-11-09',
                     'portada' => NULL,
                     'artista_id' => 1,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'I\'m Good', 
                     'resumen' => 'Primer mini-álbum.',
                     'fecha' => '2015-05-07',
                     'portada' => NULL,
                     'artista_id' => 7,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Sting', 
                     'resumen' => 'Segundo mini-álbum.',
                     'fecha' => '2016-01-18',
                     'portada' => NULL,
                     'artista_id' => 17,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'LOVE TOXIC', 
                     'resumen' => 'Segundo mini-álbum.',
                     'fecha' => '2014-08-27',
                     'portada' => NULL,
                     'artista_id' => 16,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Only One', 
                     'resumen' => 'Séptimo álbum de estudio.',
                     'fecha' => '2012-07-25',
                     'portada' => NULL,
                     'artista_id' => 5,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => 'Ima Sara Sara (4th Single)', 
                     'resumen' => 'Cuarto sencillo de la cantante.',
                     'fecha' => '2014-09-17',
                     'portada' => NULL,
                     'artista_id' => 19,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['titulo' => '3.3', 
                     'resumen' => 'Tercer mini-álbum',
                     'fecha' => '2015-12-01',
                     'portada' => NULL,
                     'artista_id' => 16,
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

        			 ];

        DB::table('discos')->insert($discos);
    }
}
