@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Perfil</h3>
	Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}
    
@endsection