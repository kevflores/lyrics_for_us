<?php

use App\CategoriaUsuario;
use App\Usuario;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = CategoriaUsuario::all();

        $usuarios = factory(Usuario::class)->times(12)->make();

        foreach ($usuarios as $usuario) {
            $categoria = $categorias->random();

            // $usuario->categoria_usuario_id = $categoria->id
            // $usuario->save()
            $categoria->usuarios()->save($usuario);
        }
    }
}
