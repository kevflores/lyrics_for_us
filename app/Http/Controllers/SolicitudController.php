<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class SolicitudController extends Controller
{
    public function verLista()
    {
        // Mostrar la lista de solicitudes realizadas por el usuario autenticado.
        return view('userview.solicitudes.ver_lista', ['usuario' => Auth::User()]);
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
    }
}
