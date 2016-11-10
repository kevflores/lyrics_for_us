<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioArtista extends Model
{
    protected $table = 'comentarios_artistas';

    protected $fillable = ['descripcion'];

    // Un comentario pertenece a un artista.
    public function artista()
    {
        return $this->belongsTo('App\Artista', 'artista_id', 'id');
    }
}
