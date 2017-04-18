<?php

namespace App\Http\Controllers;
use App\Artista;
use App\Disco;
use App\Cancion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function index()
    {
    	return view('userview.busqueda.index', ['usuario' => Auth::User()]);
    }

    public function resultados(Request $request)
    {
    	// Mostrar los resultados relacionados al término especificado en el campo de búsqueda.

        $tipo_busqueda = $request['tipo_busqueda'];
        $palabra_clave = preg_replace('/\s+/', ' ', trim($request['palabra_clave'])); // Para eliminar espacios en blanco extras.

        // VALIDAR que palabra_clave NO esté vacía para no realizar ninguna búsqueda.
        if ( $palabra_clave === null || $palabra_clave === '') {
            $tipo_busqueda = 4; // Para que no se muestren resultados.
            $mensajeError = "Debe ingresar al menos una palabra clave.";
        } else {
            $palabras = preg_replace('/\s+/', '|', $palabra_clave); // Se conforma el conjunto de palabras clave.
            $mensajeError = null;
        }

        $rTodos = null;
        $rCanciones = null;
        $rArtistas = null;
        $rDiscos = null;

        switch ( $tipo_busqueda ) {
            case 0: // Buscar TODO (Canciones, Artistas y Discos).
                $rTodos = true;
                $rArtistas = DB::table('artistas')->select('*')
                                ->where(DB::raw('UPPER(nombre)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
                $rDiscos = DB::table('discos')->select('*')
                                ->where(DB::raw('UPPER(titulo)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
                $rCanciones = DB::table('canciones')->select('*')
                                ->where(DB::raw('UPPER(titulo)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
                break;
            case 1: // Buscar sólo canciones.
                $rArtistas = DB::table('artistas')->select('*')
                                ->where(DB::raw('UPPER(nombre)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
    			break;
    		case 2: // Buscar sólo artistas.
    			$rDiscos = DB::table('discos')->select('*')
                                ->where(DB::raw('UPPER(titulo)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
    			break;
    		case 3: // Buscar sólo discos.
    			$rCanciones = DB::table('canciones')->select('*')
                                ->where(DB::raw('UPPER(titulo)'), '~', DB::raw("UPPER('".$palabras."')"))
                                ->get();
    			break;
    		default:
    			$rTodos = false;
    			break;
    	}

    	return view('userview.busqueda.resultados', ['usuario' => Auth::User(),
                                                             'tipo_busqueda' => $tipo_busqueda,
                                                             'palabra_clave' => $palabra_clave,
                                                             'rTodos' => $rTodos,
                                                             'rCanciones' => $rCanciones,
                                                             'rArtistas' => $rArtistas,
                                                             'rDiscos' => $rDiscos,
                                                             'mensajeError' => $mensajeError]);
    }

}
