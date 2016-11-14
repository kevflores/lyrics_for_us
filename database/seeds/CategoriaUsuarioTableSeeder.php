<?php
use App\CategoriaUsuario;
use Illuminate\Database\Seeder;

class CategoriaUsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaUsuario::create(['descripcion' => 'Administrador']);
        CategoriaUsuario::create(['descripcion' => 'Usuario']);
    }
}
