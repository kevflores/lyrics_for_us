<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Solicitud;
use App\TipoSolicitud;

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

        $tiposSolicitudes = TipoSolicitud::pluck('descripcion', 'id');

        return view('userview.solicitudes.ver_lista', ['usuario' => $usuario, 
                                                       'solicitudes' => $solicitudes,
                                                       'tiposSolicitudes' => $tiposSolicitudes]);
    }

    public function verSolicitud($id_solicitud)
    {
        // Mostrar la información correspondiente al registro de la solicitud seleccionada.

        if ( ctype_digit($id_solicitud) ) {
            // Si el ID de la solicitud es un valor entero...
            $usuario = Auth::User();
            $solicitud = Solicitud::find($id_solicitud);

            if ( $solicitud ) {
                // Si la solicitud pertenece al usuario autenticado, entonces se muestra
                if ( $solicitud->usuario_solicitante_id === $usuario->id ) {
                    return view('userview.solicitudes.ver_solicitud', 
                        ['usuario' => $usuario, 'solicitud' => $solicitud]);
                }
            }
        }
        // Sino, se redirecciona a la lista de solicitudes.
        return redirect()->action("SolicitudController@verLista");
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
