<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
    	// Mostrar los resultados relacionados al término especificado en el campo de búsqueda.
    	return view('userview.busqueda.index', ['usuario' => Auth::User()]);
    }

}
