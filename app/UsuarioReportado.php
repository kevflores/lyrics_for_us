<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioReportado extends Model
{
    protected $table = 'usuarios_reportados';

    protected $fillable = ['descripcion', 'usuario_reportado_id', 'usuario_reportante_id', 'usuario_admin_id'];

    // Un reporte es creado para reportar a un usuario.
    public function usuario()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_reportado_id', 'id');
    }

    // Un reporte es creado por un usuario reportante.
    public function reportante()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_reportante_id', 'id');
    }

    // Un reporte es atendido por un administrador.
    public function administrador()
    {
    	return $this->belongsTo('App\Usuario', 'usuario_admin_id', 'id');
    }


}
