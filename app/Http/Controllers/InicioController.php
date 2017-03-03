<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Cancion;
use App\CancionLetra;

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

class InicioController extends Controller
{
	public function index()
	{
    	// return view('welcome'); // Página principal (usada como "intro" de la app) 
        return redirect()->action("InicioController@indexUsuario");
	}

    public function indexUsuario()
    {    
        // Se consultan las últimas letras registradas en la app.
        $ultimasLetras = DB::table('canciones_letras AS a')
                         ->join('canciones AS b', 'a.cancion_id', 'b.id')
                         ->join('usuarios AS c', 'a.usuario_id', 'c.id')
                         ->select('a.fecha_letra', 'a.cancion_id', 'a.usuario_id', 'b.titulo', 'b.portada', 'c.nickname')
                         ->where('usuario_proveedor', true)
                         ->orderBy('a.fecha_letra', 'desc')
                         ->take(15)->get();

        $topCancionesFavoritas = DB::table('canciones AS a')
                                ->join('canciones_favoritas AS b', 'a.id', 'b.cancion_id')
                                ->select('a.id', 'a.titulo', 'a.portada', DB::raw('count(b.cancion_id) AS cantidad'))
                                ->groupBy('a.id', 'a.titulo')
                                ->orderBy('cantidad', 'desc')
                                ->orderBy('titulo', 'asc')
                                ->take(5)->get();

        $topUsuariosColaboradores = DB::table('usuarios AS a')
                                    ->join('canciones_letras AS b', 'a.id', 'b.usuario_id')
                                    ->select('a.id', 'a.nombre', 'a.nickname', 'a.imagen', DB::raw('sum(b.visitas) AS visualizaciones'))
                                    ->where('b.visitas', '>', 0)
                                    ->groupBy('a.id', 'a.nombre', 'a.nickname')
                                    ->orderBy('visualizaciones', 'desc')
                                    ->orderBy('a.nickname', 'asc')
                                    ->take(5)->get();

    	return view('userview.home', ['usuario' => Auth::User(),
                                      'ultimasLetras' => $ultimasLetras,
                                      'topCancionesFavoritas' => $topCancionesFavoritas,
                                      'topUsuariosColaboradores' => $topUsuariosColaboradores]);
    }

	public function indexAdmin()
    {
    	return view('adminview.home', ['usuario' => Auth::User()]);
    }
}
