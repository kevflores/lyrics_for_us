@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Perfil</h3>
	
	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="perfil-seccion-datos">
			<h4>Datos:</h4>
			<ul>
				@if ( $usuarioPerfil->id == Auth::User()->id )
					<li><a href="#">Editar</a></li>
				@endif
				<li>Nickname:</li>
				<li>Foto:</li>
				<li>Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}</li>
				<li>Dirección URL:</li>
				<li>Puntos obtenidos:</li>
			</ul>
		</div>

		<div class="perfil-seccion-opciones">
			<h4>Opciones</h4>
			<ul>
				<li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
				@if ( $usuarioPerfil->id != Auth::User()->id )
					<li><a href="#">Enviar mensaje privado</a></li>
					<li><a href="#">Reportar</a></li>
				@endif
			</ul>
		</div>

		<div class="perfil-seccion-letras">
			<h4>Letras</h4>
			<ul>
				<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
			</ul>
		</div>

		<div class="perfil-seccion-comentarios">
			<h4>Comentarios</h4>
			<ul>
				<li><a href="#">Ver comentarios</a></li>
				<li><a href="#">Comentar</a></li>
			</ul>
		</div>

	@else {{-- Sino, un guest/invitado está accediendo al perfil de un usuario  --}}

        <div class="perfil-seccion-datos">
        	<h4>Datos:</h4>
			<ul>
				<li>Nickname:</li>
				<li>Foto:</li>
				<li>Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}</li>
				<li>Dirección URL:</li>
				<li>Puntos obtenidos:</li>
			</ul>
		</div>

		<div class="perfil-seccion-opciones">
			<h4>Opciones:</h4>
			<ul>
				<li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
			</ul>
		</div>

		<div class="perfil-seccion-letras">
			<h4>Letras:</h4>
			<ul>
				<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
			</ul>
		</div>

		<div class="perfil-seccion-comentarios">
			<h4>Comentarios:</h4>
			<ul>
				<li><a href="#">Ver comentarios</a></li>
			</ul>
		</div>

	@endif
    
@endsection