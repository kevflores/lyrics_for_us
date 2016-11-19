<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class CancionController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a una canción.
        return view('userview.canciones.index', ['usuario' => Auth::User()]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de canciones asociadas a la selección del usuario.
        return view('userview.canciones.ver_lista', ['usuario' => Auth::User()]);
    }
    
    public function verInformacion($id_cancion)
    {
        // Mostrar la información de una canción.
        return view('userview.canciones.ver_informacion', ['usuario' => Auth::User()]);
    }
    
    public function comentar(Request $request, $id_cancion)
    {
        // Registrar el comentario realizado sobre una canción.
    }
    
    public function favorita($id_cancion)
    {
        // Agregar o quitar como favorita (del usuario autenticado) a una canción.
    }

    public function guardarLetra(Request $request, $id_cancion)
    {
        // Almacenar la letra (provista por un usuario) de una canción.
    }

    public function reportarLetra(Request $request, $id_cancion)
    {
        // Registrar el reporte realizado sobre la letra de una canción.
    }
}
