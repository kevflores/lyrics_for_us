<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioCancion extends Model
{
    protected $table = 'comentarios_canciones';

    protected $fillable = ['descripcion'];
    
    // Un comentario pertenece a una canción.
    public function cancion()
    {
        return $this->belongsTo('App\Cancion', 'cancion_id', 'id');
    }
}
