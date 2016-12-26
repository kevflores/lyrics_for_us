<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Solicitud;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use DateTime;

class SolicitudController extends Controller
{
    public function verLista()
    {
        $usuario = Auth::User();
        // Mostrar la lista de solicitudes realizadas por el usuario autenticado.
        $solicitudes = Usuario::find($usuario->id)
                                    ->solicitudesDeSolicitante()
                                    ->orderBy("fecha_solicitud","desc")
                                    ->paginate(10);

        return view('userview.solicitudes.ver_lista', ['usuario' => $usuario, 'solicitudes' => $solicitudes]);
    }

    public function verSolicitud($id)
    {
        // Mostrar la información correspondiente al registro de la solicitud seleccionada.
        return view('userview.solicitudes.ver_solicitud', ['usuario' => Auth::User()]);
    }

    public function nuevaSolicitud()
    {
    	// Mostrar el formulario necesario para realizar una nueva solicitud
        return view('userview.nueva_solicitud', ['usuario' => Auth::User()]);
    }

    public function enviarSolicitud(Request $request)
    {
        // Validar la información suminstrada en la solicitud, y registrarla en caso de proceder.
        $usuario = Auth::User();

        $this->validate($request, [
            'titulo' => 'required|string|max:50',
            'descripcion' => 'required|string',
            'tipo_solicitud' => 'required|integer|exists:tipos_solicitudes,id'
        ]);

        $solicitud = new Solicitud();
        $solicitud->titulo = $request['titulo'];
        $solicitud->descripcion = $request['descripcion'];
        $solicitud->tipo_solicitud_id = $request['tipo_solicitud'];
        $solicitud->usuario_solicitante_id = $usuario->id;
        $solicitud->fecha_solicitud = new DateTime();
        $solicitud->save();

        $idSolicitud = $solicitud->id;

        return redirect()->back()->with(['solicitudEnviada' => $idSolicitud]);
    }
}
