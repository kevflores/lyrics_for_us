<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';

    protected $fillable = ['asunto', 'descripcion'];

    // Un mensaje es enviado por un usuario.
    public function usuarioEmisor()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_emisor_id', 'id');
    }

    // Un mensaje es recibido por un usuario.
    public function usuarioReceptor()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_receptor_id', 'id');
    }
}
