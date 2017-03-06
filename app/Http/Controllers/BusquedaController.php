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
    
    	return view('userview.busqueda.index', ['usuario' => Auth::User()
    											]);
    }

    public function resultados(Request $request)
    {
    	// Mostrar los resultados relacionados al término especificado en el campo de búsqueda.
    	$this->validate($request, [
    							'tipo_busqueda' => 'required',
    							'palabra_clave' => 'required|string'
    							]);

    	$tipo_busqueda = $request['tipo_busqueda'];
    	$palabra_clave = $request['palabra_clave'];

    	switch ( $tipo_busqueda ) {
    		case 0: // Buscar TODO (Canciones, Artistas y Discos).
    			$resultados = 'TODO';
    			break;
    		case 1: // Buscar sólo canciones.
    			$rCanciones = DB::table('canciones')->select('*')
    												->where(DB::raw('UPPER(titulo)'), 'LIKE', DB::raw('UPPER(\'%'.$palabra_clave.'%\')'))
    												->get();
    			return view('userview.busqueda.resultados', ['usuario' => Auth::User(),
    														 'resultados' => $resultados=null,
    														 'rCanciones' => $rCanciones]);
    			break;
    		case 2: // Buscar sólo artistas.
    			$resultados = Artista::where('nombre','LIKE', '%'.$palabra_clave.'%')->get();
    			break;
    		case 3: // Buscar sólo discos.
    			$resultados = Disco::where('titulo','LIKE', '%'.$palabra_clave.'%')->get();
    			break;
    		default:
    			$resultados = 'No hay resultados';
    			break;
    	}

    	return view('userview.busqueda.resultados', ['usuario' => Auth::User(),
    												 'resultados' => $resultados]);
    }

}
