<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function verLista()
    {
        // Mostrar la lista de solicitudes realizadas por el usuario autenticado.
    }

    public function verSolicitud($id)
    {
        // Mostrar la información correspondiente al registro de la solicitud seleccionada.
    }

    public function nuevaSolicitud()
    {
    	// Mostrar el formulario necesario para realizar una nueva solicitud
    }

    public function enviarSolicitud(Request $request)
    {
        // Validar la información suminstrada en la solicitud, y registrarla en caso de proceder.
    }
}
