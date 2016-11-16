<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un artista.
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de artistas asociados a la selección del usuario.
    }
    
    public function verInformacion($id_artista)
    {
        // Mostrar la información de un artista específico.
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
