<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $table = 'artistas';

    protected $fillable = ['nombre', 'resumen', 'imagen'];

    // Un artista puede tener muchos nombres alternativos.
    public function nombresAlternativos()
    {
        return $this->hasMany('App\NombreArtista');
    }
	
    // Un artista puede tener muchos discos.
	public function discos()
    {
        return $this->hasMany('App\Disco');
    }

    // Un artista puede tener muchas canciones.
    public function canciones() 
    {
        return $this->belongsToMany('App\Cancion',
        							'canciones_artistas', 
        							'artista_id', 
        							'cancion_id')
        							->withPivot('invitado'); // Comprobar si se debe añadir 'id'.
    }

    // Un artista puede ser favorito de muchos usuarios.
    public function usuarios() 
    {
    	return $this->belongsToMany('App\Usuario',
                                    'artistas_favoritos', 
                                    'artista_id', 
                                    'usuario_id')
                                    ->withPivot('fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Los artistas pueden tener muchos usuarios que comenten sobre ellos.
    public function usuariosComentaristas() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'comentarios_artistas', 
                                    'artista_id', 
                                    'usuario_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Un artista puede tener muchos comentarios.
    public function comentarios()
    {
        return $this->hasMany('App\ComentarioArtista', 'artista_id', 'id');
    }
}

