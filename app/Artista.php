<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $table = 'artistas';

    protected $fillable = ['nombre', 'resumen', 'imagen'];
	
	public function discos()
    {
        return $this->hasMany('App/Disco');
    }

    public function canciones() // Opción 1
    {
        return $this->belongsToMany('App/CancionArtista',
        							'canciones_artistas', 
        							'artista_id', 
        							'cancion_id')
        							->withPivot('invitado'); // Comprobar si se debe añadir 'id'.
    }

    public function canciones() // Opción 2
    {
    	return $this->hasMany('App/CancionArtista');
    }
}

