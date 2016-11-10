<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDisco extends Model
{
    protected $table = 'comentarios_discos';

    protected $fillable = ['descripcion'];

    // Un comentario pertenece a un disco.
    public function disco()
    {
        return $this->belongsTo('App\Disco', 'disco_id', 'id');
    }
}
