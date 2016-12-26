<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = ['descripcion', 'tipo_solicitud_id', 'usuario_solicitante_id', 'usuario_admin_id'];

    // Una solicitud pertenece a un tipo de solicitud.
    public function tipo()
    {
    	return $this->belongsTo('App\TipoSolicitud', 'tipo_solicitud_id', 'id');
    }
    
    // Una solicitud es creada por un usuario.
    public function usuario()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_solicitante_id', 'id');
    }

    // Una solicitud es atendida por un usuario.
    public function administrador()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_admin_id', 'id');
    }
}
