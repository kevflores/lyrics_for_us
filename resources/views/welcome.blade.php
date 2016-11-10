@extends('layouts.master_welcome')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h1>Título de Prueba | Página Inicial</h1>

	<div class="botones_inicio">
		<div class="central">	
		<a href="{{ route('userhome') }}"><button type="button" class="btn btn-primary btn-lg boton_inicio">Modo Usuario</button></a>
		<br>
		<br>
		<a href="{{ route('adminhome') }}"><button type="button" class="btn btn-primary btn-lg boton_inicio">Modo Administrador</button></a>
		</div>
	</div>

@endsection