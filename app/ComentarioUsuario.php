<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioUsuario extends Model
{
    protected $table = 'comentarios_usuarios';

    protected $fillable = ['descripcion'];

    // Un comentario pertenece a un usuario receptor.
    public function usuarioReceptor()
    {
        return $this->belongsTo('App\Usuario', 'usuario_receptor_id', 'id');
    }

    // Un comentario pertenece a un usuario emisor.
    public function usuarioEmisor()
    {
        return $this->belongsTo('App\Usuario', 'usuario_emisor_id', 'id');
    }
}
