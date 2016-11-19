<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DiscoController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un disco.
        return view('userview.discos.index', ['usuario' => Auth::User()]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de discos asociados a la selección del usuario.
        return view('userview.discos.ver_lista', ['usuario' => Auth::User()]);
    }
    
    public function verInformacion($id_disco)
    {
        // Mostrar la información de un disco.
        return view('userview.discos.ver_informacion', ['usuario' => Auth::User()]);
    }
    
    public function comentar(Request $request, $id_disco)
    {
        // Registrar el comentario realizado sobre un disco.
    }
    
    public function favorito($id_disco)
    {
        // Agregar o quitar como favorito (del usuario autenticado) a un disco.
    }
}
