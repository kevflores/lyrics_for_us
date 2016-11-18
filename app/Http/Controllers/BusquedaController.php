<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
    	// Mostrar los resultados relacionados al término especificado en el campo de búsqueda.
    	return view('userview.busqueda.index');
    }

}
