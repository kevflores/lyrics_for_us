@extends('layouts.master_usuario')

@section('titulo')
    Disco: "{{ $disco->titulo }}" | Lyrics For Us
@endsection

@section('contenido')
    
	@if ($usuario) {{-- Si un usuario autenticado está accediendo a la información de un disco --}}
		@include('includes.bloque_de_mensajes')
		@include('includes.modal_comentar_disco')
	@endif

	<div class="lfu-seccion-completa col-xs-12">
    	
    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de Datos del Disco--}}
	    	<div class="panel panel-primary" id="lfu-disco-panel-datos">
				<div class="panel-heading" id="lfu-disco-panel-heading-datos">
					<strong>Disco</strong>
				</div>
				<div class="panel-body" id="lfu-disco-panel-body-datos">
					
					@if (Storage::disk('img-discos')->has($disco->portada))
			            <div class="imagen-disco" style="margin-bottom:15px;">
			            	<span><img src="{{ route('discos.imagen', ['imagenNombre' => $disco->portada]) }}" alt="{{ $disco->titulo }}" class="img-responsive img-rounded lfu-avatar"></span>
			            </div> 
					@else
					 	<div class="imagen-disco" style="margin-bottom:15px;">
							<span><img src="{{ asset('images\lfu-default-disco.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
						</div> 
					@endif

					<hr class="lfu-separador">

					<div class="disco-dato">
						<strong>
							<i class="fa fa-play lfu-fa-icon" aria-hidden="true"></i>
							"{{ $disco->titulo }}"
						</strong>

						de <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artistaDisco->id]) }}" title="">{{ $artistaDisco->nombre }}</a>

					</div>

					@if ( $disco->fecha )
						<div class="disco-dato"> 
							Fecha de lanzamiento: {{ date('d/m/Y', strtotime($disco->fecha)) }}
						</div>
					@endif

					@if ( $disco->resumen )
						<div class="disco-dato resumen-disco"> "{{ $disco->resumen }}"</div>
					@endif

					{{-- <!-- Código para actualizar la portada del disco [SE DEBE USAR al momento de implementar la función del Administrador] -->
					@if ( $usuario )
					<form action="{{ route('discos.actualizar_imagen', ['id_disco' => $disco->id]) }}" method="post", id='lfu-form-config-imagen' enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="form-group col-xs-12 {{ $errors->has('imagen') ? 'has-error' : '' }}">
							<div class="form-control seleccionarImagen">
							    <span class="spanImagen">Seleccionar imagen</span>
							    <input type="file" name="imagen" class="subirImagen"/>
							</div>
        				</div>
						<button type="submit" class="btn btn-primary">Subir nueva imagen</button>
					</form>
					@endif
					--}}
					
					<hr class="lfu-separador">
				</div>
		    </div>
		    {{-- Sección de Opciones --}}
	    	<div class="panel panel-primary disco-seccion-popularidad" id="lfu-disco-panel-popularidad">
				<div class="panel-heading" id="lfu-disco-panel-heading-popularidad">Popularidad</div>
				<div class="panel-body" id="lfu-disco-panel-body-popularidad">
					
					@if ( $usuario )
						@if ( count($usuarioFavorito) )
							<div class="disco-cantidad-favoritos">
								@if ( $numeroFavoritos === 1 )
									"{{ $disco->titulo }}" es uno de tus discos favoritos
								@elseif ( $numeroFavoritos === 2 )
									Tú y otro usuario tienen a "{{ $disco->titulo }}" en su lista de discos favoritos
								@else 
									Tú y <strong>{{ $numeroFavoritos }}</strong> usuarios tienen a "{{ $disco->titulo }}" en su lista de discos favoritos
								@endif
							</div>
							<div class="disco-opcion">
								<i class="fa fa-minus-circle lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-eliminar-disco-favoritos" style="cursor:pointer">
									Eliminar de mi lista de discos favoritos
								</a>
								<form action="{{ route('discos.favorito') }}" id="lfu-eliminar-disco-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_disco" value="{{ $disco->id }}">
									<input type="hidden" name="opcion" value="eliminar">
								</form>
							</div>
						@else
							<div class="disco-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									"{{ $disco->titulo }}" aún no ha sido agregado a una lista de discos favoritos
								@elseif ( $numeroFavoritos === 1)
									"{{ $disco->titulo }}" es uno de los discos favoritos de un usuario
								@else
									"{{ $disco->titulo }}" es uno de los discos favoritos de <strong>{{ $numeroFavoritos }}</strong> usuarios
								@endif
							</div>
							<div class="disco-opcion">
								<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-agregar-disco-favoritos" style="cursor:pointer">
									Agregar a mi lista de discos favoritos
								</a>
								<form action="{{ route('discos.favorito') }}" id="lfu-agregar-disco-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_disco" value="{{ $disco->id }}">
									<input type="hidden" name="opcion" value="agregar">
								</form>
							</div>
						@endif
					@else
						<div class="disco-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									"{{ $disco->titulo }}" aún no ha sido agregado a una lista de discos favoritos
								@elseif ( $numeroFavoritos === 1)
									"{{ $disco->titulo }}" es uno de los discos favoritos de un usuario
								@else
									"{{ $disco->titulo }}" es uno de los discos favoritos de <strong>{{ $numeroFavoritos }}</strong> usuarios
								@endif
							</div>
					@endif
				</div>
		    </div>		    
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
    		{{-- Sección de la lista de canciones del Disco --}}
	    	<div class="panel panel-primary disco-seccion-canciones" id="lfu-disco-panel-canciones">
				<div class="panel-heading" id="lfu-disco-panel-heading-canciones">Lista de canciones de "{{ $disco->titulo }}"</div>
				<div class="panel-body" id="lfu-disco-panel-body-canciones">

					@if ( count($cancionesDisco) === 0 ) 
						<hr class="lfu-separador">
						Aún no existen registros de las canciones incluidas en el disco.
						<span style="font-style:italic;color:red;">(Mostrar imagen)</span>
						{{-- Mostrar alguna imagen alusiva --}}
						<hr class="lfu-separador">
					@else
						{{-- Si el disco tiene canciones... --}}
						<hr class="lfu-separador">
						@foreach ( $cancionesDisco as $cancion )
							"<strong><a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a></strong>"
							@include('includes.imprimir_artistas_invitados')
							<hr class="lfu-separador-cancion-mismo-disco">
						@endforeach
						<hr class="lfu-separador">
					@endif

				</div>
			</div>
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12" >
		{{-- Sección de Comentarios --}}
		<div class="panel panel-primary disco-seccion-comentarios no-border-bottom" id="lfu-panel-disco-comentarios">
			<div class="panel-heading" id="lfu-disco-panel-heading-comentarios">
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
					@if ( $comentariosDisco->count() > 0 )
						@foreach($comentariosDisco as $comentario)
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

	<!--Prueba para el front-end-->
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>
         
@endsection