@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us | Administrador
@endsection

@section('contenido')
    
	<h3>Título de Prueba (Vista de Administrador)</h3>

    @for($i=0;$i<20;$i++)
        Contenido y Formulario de Prueba {{$i+1}}
    @endfor
    

@endsection