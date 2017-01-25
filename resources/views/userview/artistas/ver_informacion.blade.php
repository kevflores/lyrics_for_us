@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	@if ($usuario) {{-- Si un usuario autenticado está accediendo a la información de un artista --}}
		@include('includes.bloque_de_mensajes')
		@include('includes.modal_comentar_artista')
	@endif

	<div class="lfu-seccion-completa col-xs-12">
    	
    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de Datos --}}
	    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
				<div class="panel-heading" id="lfu-perfil-panel-heading-datos">
					<strong>Artista</strong>
				</div>
				<div class="panel-body" id="lfu-perfil-panel-body-datos">
					
					@if (Storage::disk('img-artistas')->has($artista->imagen))
			            <div class="imagen-perfil" style="margin-bottom:15px;">
			            	<span><img src="{{ route('artistas.imagen', ['imagenNombre' => $artista->imagen]) }}" alt="{{ $artista->nombre }}" class="img-responsive img-rounded lfu-avatar"></span>
			            </div> 
					@else
					 	<div class="imagen-perfil" style="margin-bottom:15px;">
							<span><img src="{{ asset('images\lfu-default-artista.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
						</div> 
					@endif

					<hr class="lfu-separador">
					<div class="perfil-dato-usuario"><i class="fa fa-user-circle-o lfu-fa-icon" aria-hidden="true"></i> {{ $artista->nombre }}</div>
					@if ( $artista->resumen )
						<div class="perfil-dato-usuario resumen-usuario"> "{{ $artista->resumen }}"</div>
					@endif
					<hr class="lfu-separador">
				</div>
		    </div>
		    {{-- Sección de Opciones --}}
	    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
				<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
				<div class="panel-body" id="lfu-perfil-panel-body-opciones">
					A 10 usuarios les gusta {{ $artista->nombre }}
					@if ($usuario)
						<div class="perfil-opcion-usuario">
							<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
							<a href="#">Agregar a favoritos</b></a>
						</div>
					@endif
				</div>
		    </div>		    
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
    		{{-- Sección de Letras --}}
	    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="">
				<div class="panel-heading" id="lfu-perfil-panel-heading-letras">Trabajos de {{ $artista->nombre }}</div>
				<div class="panel-body" id="lfu-perfil-panel-body-letras">

			    	Discos
			    	
			    	<form action="{{ route('artistas.actualizar_imagen', ['id_artista' => $artista->id]) }}" method="post", id='lfu-form-config-imagen' enctype="multipart/form-data">
					{!! csrf_field() !!}

						<div class="form-group col-xs-12 {{ $errors->has('imagen') ? 'has-error' : '' }}">
							<div class="form-control seleccionarImagen">
							    <span class="spanImagen">Seleccionar imagen</span>
							    <input type="file" name="imagen" class="subirImagen"/>
							</div>
        				</div>

	        			{!! Form::token() !!}
						<button type="submit" class="btn btn-primary">Subir nueva imagen</button>

					</form>

			        
				</div>
			</div>
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12" >
		{{-- Sección de Comentarios --}}
		<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-panel-comentarios">
			<div class="panel-heading" id="lfu-panel-heading-comentarios">
				<i class="fa fa-comments-o" aria-hidden="true"></i> 
				<a data-toggle="collapse" class="ver-comentarios" href="#lfu-panel-collapse-comentarios">Mostrar comentarios</a>
				<a data-toggle="collapse" class="ocultar-comentarios" href="#lfu-panel-collapse-comentarios">Ocultar comentarios</a>
			</div>
			<div id="lfu-panel-collapse-comentarios" class="panel-collapse collapse">
				<div class="panel-body">
					@if ( $usuario )
						<a id="lfu-comentar" style="cursor:pointer">Comentar</a>
					@endif
					<div class="media" id="lfu-comentarios">
					@if ( $comentariosArtista->count() > 0 )
						@foreach($comentariosArtista as $comentario)
							<div class="media-left lfu-container-avatar-comentario">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $comentario->nickname]) }}">
								@if (Storage::disk('avatars')->has($comentario->imagen_usuario))
						            <img src="{{ route('usuario.avatar', ['imagenNombre' => 'thumbnail_'.$comentario->imagen_usuario]) }}" alt="{{ $comentario->nickname }}" class="img-circle media-object lfu-comentario-avatar">
								@else
									<img src="{{ asset('images\lfu-default-avatar.png') }}" alt="{{ $comentario->nickname }}" class="img-circle media-object lfu-comentario-avatar" >
								@endif
								</a>
							</div>

							<div class="media-body lfu-comentario-individual">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $comentario->nickname]) }}">
									<strong class="media-heading lfu-comentario-autor">{{$comentario->nickname}}</strong>
								</a>
								@if ( $usuario )
									@if ($comentario->usuario_id === $usuario->id)
									<strong>(Tú)</strong>
									@endif
								@endif
								<span style="font-style:italic;font-size:12px;"> (El {{ date('d/m/Y', strtotime($comentario->fecha)) }} a las {{ date('H:m:s', strtotime($comentario->fecha)) }})</span>
								<p id="lfu-comentario-descripcion">{{ $comentario->descripcion }}</p>
							</div>

							<hr class="lfu-separador-comentarios">
						@endforeach
						<i class="fa fa-circle-o lfu-fa-icon" aria-hidden="true"></i>
					@else
						<p>No hay comentarios</p>
						<hr class="lfu-separador-comentarios">
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>
    
@endsection