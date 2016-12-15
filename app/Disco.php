<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disco extends Model
{
    protected $table = 'discos';

    protected $fillable = ['titulo', 'resumen', 'portada'];

    // Un disco pertenece a un artista.
	public function artista()
    {
        return $this->belongsTo('App\Artista');
    }

    // Un disco puede tener muchas canciones.
    public function canciones()
    {
    	return $this->hasMany('App\Cancion');
    }

    // Un disco puede ser favorito de muchos usuarios.
    public function usuarios() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'discos_favoritos', 
                                    'disco_id', 
                                    'usuario_id')
                                    ->withPivot('fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Un disco puede tener muchos comentarios.
    public function comentarios()
    {
        return $this->hasMany('App\ComentarioDisco', 'disco_id', 'id');
    }

    // Los discos pueden tener muchos usuarios que comenten sobre ellps.
    public function usuariosComentaristas() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'comentarios_discos', 
                                    'disco_id', 
                                    'usuario_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

}