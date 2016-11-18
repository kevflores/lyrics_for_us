<?php

namespace App\Http\Controllers;
use App\Usuario;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
	public function index()
	{
    	return view('welcome');
	}

    public function indexUsuario()
    {    
        //$usuario = Auth::usuario();
    	//return view('userview.home', ['usuario' => Auth::Usuario()]);
        return view('userview.home');
    }

	public function indexAdmin()
    {
    	return view('adminview.home');
    }
}
