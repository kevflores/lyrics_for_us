<?php

use Illuminate\Database\Seeder;

class TipoSolicitudTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos_solicitudes = [
        			['descripcion' => 'Registro de artista',
        			'created_at' => new DateTime, 
                    'updated_at' => new DateTime],
        			['descripcion' => 'Registro de disco',
        			'created_at' => new DateTime, 
                    'updated_at' => new DateTime],
        			['descripcion' => 'Registro de canción',
        			'created_at' => new DateTime, 
                    'updated_at' => new DateTime],
        ];
        DB::table('tipos_solicitudes')->insert($tipos_solicitudes);
    }
}
