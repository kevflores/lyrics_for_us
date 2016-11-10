<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaUsuario extends Model
{
    protected $table = 'categorias_usuarios';

    protected $fillable = ['descripcion'];

    // Una categoría puede agrupar a muchos usuarios.
    public function usuarios()
    {
    	return $this->hasMany('App\Usuario', 'categoria_usuario_id', 'id');
    }
}
