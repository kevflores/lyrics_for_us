<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ArtistaTableSeeder::class);
        $this->call(CategoriaUsuarioTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(DiscoTableSeeder::class);
        $this->call(CancionTableSeeder::class);
        $this->call(CancionArtistaTableSeeder::class);
        $this->call(TipoSolicitudTableSeeder::class);
    }
}
