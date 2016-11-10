<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NombreArtista extends Model
{
    protected $table = 'nombres_artistas';

    protected $fillable = ['nombre_alternativo'];

    // Un nombre alternativo pertenece a un artista.
    public function artista()
    {
        return $this->belongsTo('App\Artista');
    }
}
