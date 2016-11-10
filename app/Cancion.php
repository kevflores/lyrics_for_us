<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    protected $table = 'canciones';

    protected $fillable = ['titulo', 'resumen', 'disco_id', 'autor', 'compositor',
    					   'audio', 'portada', 'letra', 'usuario_id', 'usuario_modificador_id'];

    // Muchas canciones pueden pertenecer a varios artistas.
    public function artistas() 
    {
        return $this->belongsToMany('App\Artista',
        							'canciones_artistas', 
        							'cancion_id', 
        							'artista_id')
        							->withPivot('invitado'); // Comprobar si se debe añadir 'id'.
    }

    // Una canción puede tener muchos comentarios.
    public function comentarios()
    {
        return $this->hasMany('App\ComentarioCancion', 'cancion_id', 'id');
    }

    // Una canción pertenece a un disco.
    public function disco()
    {
        return $this->belongsTo('App\Disco');
    }

    // Una canción puede poseer una letra provista por un usuario.
    public function usuario() {
        return $this->belongsTo('App/Usuario', 'usuario_id', 'id');
    }

    // Una canción puede poseer una letra modificada por un usuario.
    public function usuarioModificador() {
        return $this->belongsTo('App/Usuario', 'usuario_modificador_id', 'id');
    }

    // Una canción puede ser favorita de muchos usuarios.
    public function usuarios() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'canciones_favoritas', 
                                    'cancion_id', 
                                    'usuario_id')
                                    ->withPivot('fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Las canciones pueden tener muchos usuarios que comenten sobre ellas.
    public function usuariosComentaristas() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'comentarios_canciones', 
                                    'cancion_id', 
                                    'usuario_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Las letras de muchas canciones pueden ser reportadas por muchos usuarios.
    public function usuariosReportantes() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'letras_reportadas', 
                                    'cancion_id', 
                                    'usuario_reportante_id')
                                    ->withPivot('descripcion', 'fecha_reporte', 'usuario_admin_id', 'fecha_atencion'); // Comprobar si se debe añadir 'id'.
    }

    // Los reportes de las letras de muchas canciones pueden ser atendidos por muchos administradores.
    public function usuariosAdministradores() 
    {
        return $this->belongsToMany('App\Usuario',
                                    'letras_reportadas', 
                                    'cancion_id', 
                                    'usuario_admin_id')
                                    ->withPivot('descripcion', 'fecha_reporte', 'usuario_reportante_id', 'fecha_atencion'); // Comprobar si se debe añadir 'id'.
    }
}
