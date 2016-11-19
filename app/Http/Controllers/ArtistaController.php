<?php

namespace App\Http\Controllers;
use App\Artista;
use App\ArtistaFavorito;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ArtistaController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un artista.
        return view('userview.artistas.index', ['usuario' => Auth::User()]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de artistas asociados a la selección del usuario.
        return view('userview.artistas.ver_lista', ['usuario' => Auth::User()]);
    }
    
    public function verInformacion($id_artista)
    {
        // Mostrar la información de un artista específico.
        return view('userview.artistas.ver_informacion', ['usuario' => Auth::User()]);
    }
    
    public function comentar(Request $request, $id_artista)
    {
        // Registrar el comentario realizado sobre un artista.
    }
    
    public function favorito($id_artista)
    {
        // Agregar o quitar como favorito (del usuario autenticado) a un artista específico.
    }
    
}
