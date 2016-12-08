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
        			 //'imagen' => 't_ara_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

        			 ['nombre' => 'Nelly Furtado', 
        			 'resumen' => 'Cantante candiense.',
        			 //'imagen' => 'nf_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

        			 ['nombre' => 'TVXQ!', 
        			 'resumen' => 'Dúo musical surcoreano integrado por U-Know y Max.',
        			 //'imagen' => 'tvxq_imagen.jpg', 
        			 'created_at' => new DateTime, 
        			 'updated_at' => new DateTime],

                     ['nombre' => 'Colbie Caillat', 
                     'resumen' => 'Cantante estadounidense.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'BoA', 
                     'resumen' => 'Cantate surcoreana. BoA (Beat of Angel) debutó en los escenarios a muy temprana edad.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Emmy Rossum', 
                     'resumen' => 'Actriz y cantante estadounidense. Reconocida por sus participaciones en diversas producciones cinematográficas y por la serie de TV "Shameless".',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Eunjung', 
                     'resumen' => 'Cantante y actriz surcoreana. Más conocida por formar parte del grupo T-ara.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Arashi', 
                     'resumen' => 'Grupo musical de origen japonés. Reconocido como uno de los grupos más populares en Japón.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Gain', 
                     'resumen' => 'Cantante y actriz surcoreana. Más conocida por formar parte del grupo Brown Eyed Girls.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Wonder Girls', 
                     'resumen' => 'Grupo surcoreano. El estilo musical "retro" distingue a este grupo de los demás grupos del mercado K-pop.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Hyomin', 
                     'resumen' => 'Cantante y actriz surcoreana. Más conocida por formar parte del grupo T-ara.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Jeremy Camp', 
                     'resumen' => 'Cantante estadounidense. Conocido por sus canciones de género cristiano.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Hilary Duff', 
                     'resumen' => 'Cantante y actriz estadounidense. Conocida por sus éxitos, tanto en el ámbito musical como en el actoral durante su adolescencia.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'División Minúscula', 
                     'resumen' => 'Grupo musical de rock alternativo originario de México.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Kari Jobe', 
                     'resumen' => 'Cantante estadounidense. Conocida por sus canciones cristianas en inglés y español.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Royal Pirates', 
                     'resumen' => 'Grupo musical surcoreano/estadounidense. Conformada por Moon, James y EXSY.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Stellar', 
                     'resumen' => 'Grupo musical femenino originario de Corea del Sur.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Unspoken', 
                     'resumen' => 'Grupo musical cristiano.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Tomomi Kasai', 
                     'resumen' => 'Cantante japonesa. Conocida por haber formado parte del famoso grupo AKB48.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Isaac Moraleja', 
                     'resumen' => 'Cantante de música cristiana originario de Argentina.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Meisa Kuroki', 
                     'resumen' => 'Actriz y cantante japonesa.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Younha', 
                     'resumen' => 'Cantante surcoreana.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Lily Allen', 
                     'resumen' => 'Cantante británica.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Henry Lau', 
                     'resumen' => 'Cantante canadiense de origen asiático. Conocido por formar parte del grupo Super Junior-M',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Tori Amos', 
                     'resumen' => 'Cantante estadounidense.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => 'Melody', 
                     'resumen' => 'Cantante española.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

                     ['nombre' => '9MUSES', 
                     'resumen' => 'Grupo musical femenino originario de Corea del Sur.',
                     'created_at' => new DateTime, 
                     'updated_at' => new DateTime],

        			 ];

        DB::table('artistas')->insert($artistas);
    }
}
