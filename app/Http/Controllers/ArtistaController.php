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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;



class ArtistaController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un artista.

        // Consultar los mas populares...
        $artistas = null;

        return view('userview.artistas.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'artistas' => $artistas]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de artistas asociados a la selección del usuario.

        // Validar que selección sea "top" o "#" o "a" - "z" o "A" - "Z" o "nn" o "NN"
        // Mostrar msj de error en caso que de que sea distinto...
        if ( $seleccion === 'top') {

            // Consultar los mas populares...
            $artistas = null;

        } elseif ( $seleccion === 'numero' ) {
            $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), '~', '^[0-9]')
                                    ->orderBy('nombre')->paginate(10);
        } elseif (preg_match("/^[a-zA-Z]$/", $seleccion)){
            $mayuscula = Str::upper($seleccion);
            $minuscula = Str::lower($seleccion);

            if ( $seleccion !== 'n' || $seleccion !== 'N' ) {
                $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), $minuscula)
                                ->orderBy('nombre')->paginate(10);
            } else {
                // Se consulta la lista de artistas cuyos nombres comiencen por N/Ñ
                $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), $minuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), 'Ñ')
                                ->orWhere(DB::raw('substring(nombre,1,1)'), 'ñ')
                                ->orderBy('nombre')->paginate(10);
            }
        } else {
            // El usuario (probablemente) insertó un valor NO VÁLIDO en la URL.
            return redirect()->action('ArtistaController@index');
        }
        return view('userview.artistas.ver_lista', ['usuario' => Auth::User(),
                                                    'seleccion' => $seleccion,
                                                    'artistas' => $artistas]);
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
