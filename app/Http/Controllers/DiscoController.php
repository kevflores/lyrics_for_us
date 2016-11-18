<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscoController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un disco.
        return view('userview.discos.index');
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de discos asociados a la selección del usuario.
        return view('userview.discos.ver_lista');
    }
    
    public function verInformacion($id_disco)
    {
        // Mostrar la información de un disco.
        return view('userview.discos.ver_informacion');
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
