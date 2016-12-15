<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = ['nickname','nombre', 'apellido', 'email', 'password', 'url', 'imagen', 'ubicacion'];

    protected $hidden = ['password', 'remember_token'];

    // Un usuario pertenece a una categoría.
    public function categoria()
    {
    	return $this->belongsTo('App\CategoriaUsuario', 'categoria_usuario_id', 'id');
    }

    // Un usuario puede tener muchos reportes.
    public function reportes()
    {
    	return $this->hasMany('App\UsuarioReportado', 'usuario_reportado_id', 'id');
    }

    // Un usuario puede reportar a muchos usuarios.
    public function reportesDeReportante()
    {
    	return $this->hasMany('App\UsuarioReportado', 'usuario_reportante_id', 'id');
    }

    // Un administrador puede atender muchos reportes.
    public function resportesDeAdministrador()
    {
    	return $this->hasMany('App\UsuarioReportado', 'usuario_admin_id', 'id');
    }

    // Un usuario puede realizar muchas solicitudes.
    public function solicitudesDeSolicitante()
    {
    	return $this->hasMany('App\Solicitud', 'usuario_solicitante_id', 'id');
    }

    // Un administrador puede atender muchas solicitudes.
    public function solicitudesDeAdministrador()
    {
    	return $this->hasMany('App\Solicitud', 'usuario_admin_id', 'id');
    }

    // Un usuario puede enviar muchos mensajes.
    public function mensajesDeEmisor()
    {
    	return $this->hasMany('App\Mensaje', 'usuario_emisor_id', 'id');
    }

    // Un usuario puede recibir muchos mensajes.
    public function mensajesDeReceptor()
    {
    	return $this->hasMany('App\Mensaje', 'usuario_receptor_id', 'id');
    }

    // Un usuario puede proporcionar la letra de muchas canciones.
    public function canciones()
    {
    	return $this->hasMany('App\Cancion', 'usuario_id', 'id');
    }

    // Un usuario puede modificar la letra de muchas canciones.
    public function cancionesModificadas()
    {
    	return $this->hasMany('App\Cancion', 'usuario_modificador_id', 'id');
    }

    // Muchos usuarios pueden compartir sus artistas favoritos.
    public function artistasFavoritos() 
    {
    	return $this->belongsToMany('App\Artista',
                                    'artistas_favoritos', 
                                    'usuario_id', 
                                    'artista_id')
                                    ->withPivot('fecha','id'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden compartir sus discos favoritos.
    public function discosFavoritos() 
    {
    	return $this->belongsToMany('App\Disco',
                                    'discos_favoritos', 
                                    'usuario_id', 
                                    'disco_id')
                                    ->withPivot('fecha','id'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden compartir sus canciones favoritas.
    public function cancionesFavoritas() 
    {
    	return $this->belongsToMany('App\Cancion',
                                    'canciones_favoritas', 
                                    'usuario_id', 
                                    'cancion_id')
                                    ->withPivot('fecha','id'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden hacer comentarios sobre artistas.
    public function artistasComentados() 
    {
        return $this->belongsToMany('App\Artista',
                                    'comentarios_artistas', 
                                    'usuario_id', 
                                    'artista_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden hacer comentarios sobre discos.
    public function discosComentados() 
    {
        return $this->belongsToMany('App\Disco',
                                    'comentarios_discos', 
                                    'usuario_id', 
                                    'disco_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden hacer comentarios sobre canciones.
    public function cancionesComentadas() 
    {
        return $this->belongsToMany('App\Cancion',
                                    'comentarios_canciones', 
                                    'usuario_id', 
                                    'cancion_id')
                                    ->withPivot('descripcion', 'fecha'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos usuarios pueden reportar las letras de muchas canciones.
    public function cancionesReportadas() 
    {
    	return $this->belongsToMany('App\Cancion',
                                    'letras_reportadas', 
                                    'usuario_reportante_id', 
                                    'cancion_id')
                                    ->withPivot('descripcion', 'fecha_reporte', 'usuario_admin_id', 'fecha_atencion'); // Comprobar si se debe añadir 'id'.
    }

    // Muchos administradores pueden atender los reportes de las letras de muchas canciones.
    public function cancionesReportadasAtendidas() 
    {
    	return $this->belongsToMany('App\Cancion',
                                    'letras_reportadas', 
                                    'usuario_admin_id', 
                                    'cancion_id')
                                    ->withPivot('descripcion', 'fecha_reporte', 'usuario_reportante_id', 'fecha_atencion'); // Comprobar si se debe añadir 'id'.
    }

    // Un usuario puede tener comentarios enviados.
    public function comentariosRecibidos()
    {
        //
    }

    // Un usuario puede tener comentarios recibidos.
    public function comentariosEnviados()
    {
        //
    }


}
