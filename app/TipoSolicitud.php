<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitud extends Model
{
    protected $table = 'tipos_solicitudes';

    protected $fillable = ['descripcion'];

    // Un tipo de solicitud puede agrupar muchas solicitudes.
    public function solicitudes()
    {
    	return $this->hasMany('App\Solicitud', 'tipo_solicitud_id', 'id');
    }
}
