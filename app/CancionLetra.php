<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancionLetra extends Model
{
    protected $table = 'canciones_letras';

    protected $fillable = ['cancion_id', 'usuario_id', 'letra', 'fecha_letra',
     'usuario_modificador_id', 'fecha_letra_modificada', 'usuario_proveedor', 'visitas'];

	// Una letra es provista por un usuario
    public function usuarioProveedor()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_id', 'id');
    }

    // Una letra pertenece a una canción
    public function cancion()
    {
    	return $this->belongsTo('App\Cancion', 'cancion_id', 'id');
    }


}
