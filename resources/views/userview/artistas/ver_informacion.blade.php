@extends('layouts.master_usuario')

@section('titulo')
    Artista: {{ $artista->nombre }} | Lyrics For Us
@endsection

@section('contenido')
    
	@if ($usuario) {{-- Si un usuario autenticado está accediendo a la información de un artista --}}
		@include('includes.bloque_de_mensajes')
		@include('includes.modal_comentar_artista')
	@endif

	<div class="lfu-seccion-completa col-xs-12">
    	
    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de Datos del Artista--}}
	    	<div class="panel panel-primary" id="lfu-artista-panel-datos">
				<div class="panel-heading" id="lfu-artista-panel-heading-datos">
					<strong>Artista</strong>
				</div>
				<div class="panel-body" id="lfu-artista-panel-body-datos">
					
					@if (Storage::disk('img-artistas')->has($artista->imagen))
			            <div class="imagen-artista" style="margin-bottom:15px;">
			            	<span><img src="{{ route('artistas.imagen', ['imagenNombre' => $artista->imagen]) }}" alt="{{ $artista->nombre }}" class="img-responsive img-rounded lfu-avatar"></span>
			            </div> 
					@else
					 	<div class="imagen-artista" style="margin-bottom:15px;">
							<span><img src="{{ asset('images\lfu-default-artista.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
						</div> 
					@endif

					<hr class="lfu-separador">

					<div class="artista-dato">
						<strong>
							<i class="fa fa-microphone lfu-fa-icon" aria-hidden="true"></i>
							{{ $artista->nombre }} 
						</strong>
					</div>

					@if ( count($nombresArtista) )
						@if ( count($nombresArtista) === 1 )
							<div class="artista-dato"> 
							Otro nombre:
								@foreach ($nombresArtista as $nombreAlt)
									{{ $nombreAlt->nombre_alternativo }}.
								@endforeach
							</div>
						@else {{-- Sino, entonces tiene más de un nombre alternativo --}}
							<div class="artista-dato"> 
							Otros nombres: 
								<?php $primerNombre = true; ?>
								@foreach ($nombresArtista as $nombreAlt)
									@if ( $primerNombre === true)
										{{ $nombreAlt->nombre_alternativo }}
									@else
										<span class="otroNombreArtista">/ {{$nombreAlt->nombre_alternativo}}</span>
									@endif
									<?php $primerNombre = false; ?>
								@endforeach
							</div>
						@endif
					@endif

					@if ( $artista->resumen )
						<div class="artista-dato resumen-artista"> "{{ $artista->resumen }}"</div>
					@endif

					{{-- <!-- Código para actualizar la imagen del artista [SE DEBE USAR al momento de implementar la función del Administrador] -->
					@if ( $usuario )
					<form action="{{ route('artistas.actualizar_imagen', ['id_artista' => $artista->id]) }}" method="post", id='lfu-form-config-imagen' enctype="multipart/form-data">
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
	    	<div class="panel panel-primary artista-seccion-popularidad" id="lfu-artista-panel-popularidad">
				<div class="panel-heading" id="lfu-artista-panel-heading-popularidad">Popularidad</div>
				<div class="panel-body" id="lfu-artista-panel-body-popularidad">
					
					@if ( $usuario )
						@if ( count($usuarioFavorito) )
							<div class="artista-cantidad-favoritos">
								@if ( $numeroFavoritos === 1)
									Tú eres seguidor de {{ $artista->nombre }}
								@elseif ( $numeroFavoritos === 2 )
									Tú y otro usuario más son seguidores de {{ $artista->nombre }}
								@else 
									Tú y <strong>{{ $numeroFavoritos }}</strong> usuarios más son seguidores de {{ $artista->nombre }}
								@endif
							</div>
							<div class="artista-opcion">
								<i class="fa fa-minus-circle lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-eliminar-artista-favoritos" style="cursor:pointer">
									Eliminar de mi lista de artistas favoritos
								</a>
								<form action="{{ route('artistas.favorito') }}" id="lfu-eliminar-artista-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_artista" value="{{ $artista->id }}">
									<input type="hidden" name="opcion" value="eliminar">
								</form>
							</div>
						@else
							<div class="artista-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									{{ $artista->nombre }} aún no tiene seguidores
								@elseif ( $numeroFavoritos === 1)
									{{ $artista->nombre }} tiene un seguidor
								@else
									{{ $artista->nombre }} tiene <strong>{{ $numeroFavoritos }}</strong> seguidores
								@endif
							</div>
							<div class="artista-opcion">
								<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-agregar-artista-favoritos" style="cursor:pointer">
									Agregar a mi lista de artistas favoritos
								</a>
								<form action="{{ route('artistas.favorito') }}" id="lfu-agregar-artista-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_artista" value="{{ $artista->id }}">
									<input type="hidden" name="opcion" value="agregar">
								</form>
							</div>
						@endif
					@else
						<div class="artista-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									{{ $artista->nombre }} aún no tiene seguidores
								@elseif ( $numeroFavoritos === 1)
									{{ $artista->nombre }} tiene un seguidor
								@else
									{{ $artista->nombre }} tiene <strong>{{ $numeroFavoritos }}</strong> seguidores
								@endif
							</div>
					@endif
				</div>
		    </div>		    
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
    		{{-- Sección de la Discografía del Artista --}}
	    	<div class="panel panel-primary artista-seccion-discografia" id="lfu-artista-panel-discografia">
				<div class="panel-heading" id="lfu-artista-panel-heading-discografia">Discografía de {{ $artista->nombre }}</div>
				<div class="panel-body" id="lfu-artista-panel-body-discografia">

					@if ( $sinDiscografia ) 
						<hr class="lfu-separador">
						Aún no existen registros del trabajo musical del artista.
						<span style="font-style:italic;color:red;">(Mostrar imagen)</span>
						{{-- Mostrar alguna imagen alusiva --}}
						<hr class="lfu-separador">
					@else
						{{-- Si el artista tiene discos... --}}
						<hr class="lfu-separador">
						@if ( count($discosArtista) )
							<div class="">
								<span class="label label-info">Discos</span>
						    	<hr class="lfu-separador" style="border-top: 0px;">
						    	@foreach ( $discosArtista as $disco )
								<div>
									<div>
										<strong>"<a class="lfu-enlace-sin-decoracion lfu-texto-italic" data-toggle="collapse" href="#disco-{{ $disco->id }}">{{ $disco->titulo }}</a>"</strong> ({{ date('Y', strtotime($disco->fecha))}})
									</div>
									{{-- Y se muestran las canciones que pertenecen al disco --}}
									<div id="disco-{{ $disco->id }}" class="collapse">
										<a href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}" title="">Ver información</a>
										<br>
										@if ( count((App\Disco::find($disco->id)->canciones)) )
											<hr class="lfu-separador-cancion-misma-fecha">
											Lista de canciones:
											<br>
											@foreach ( (App\Disco::find($disco->id)->canciones()->orderBy('numero')->get()) as $cancion )
												<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a>
												@include('includes.imprimir_artistas_invitados')
												<br>
											@endforeach
											<hr class="lfu-separador" style="border-top: 0px;">
										@else
										 {{-- Se coloca un separador pequeño, ya que no se muestra la lista de canciones del disco--}}
										 	<hr class="lfu-separador-simple" style="border-top: 0px;">
										@endif
										
									</div>
								</div>
								@endforeach
							</div>
							<hr class="lfu-separador">
				    	@endif

				    	{{-- Si el artista tiene canciones que no están incluidas en ningún disco... --}}
				    	@if ( count($cancionesArtistaSinDisco) )
				    		<div class="">
								<span class="label label-info">Canciones sin Disco</span>
						    	<hr class="lfu-separador" style="border-top: 0px;">
								@foreach ( $cancionesArtistaSinDisco as $cancion )
									"<strong><a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a></strong>"
									@include('includes.imprimir_artistas_invitados')
									<br>
								@endforeach
							</div>
							<hr class="lfu-separador">
				    	@endif
				    	
				    	{{-- Si el artista ha colaborado como invitado en canciones de otros artistas, y
				    	si el artista ha colaborado como artista principal en una canción, pero ésta
				    	ha sido incluida en un disco que no forma parte de su discografía... --}}
				    	@if ( count($cancionesArtistaInvitado) || count($cancionesArtistaPrincipalEnOtroDisco) )
				    		@if ( count($cancionesArtistaInvitado) )
					    		<div class="">
									<span class="label label-info">Colaboraciones con Otros Artistas</span>
							    	<hr class="lfu-separador" style="border-top: 0px;">
									@foreach ( $cancionesArtistaInvitado as $cancion )
										"<strong><a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a></strong>"
										@include('includes.imprimir_artistas_principales')
										<br>
									@endforeach
								</div>
							@endif
							@if ( count($cancionesArtistaPrincipalEnOtroDisco) )
					    		<div class="">
									<span class="label label-info">Colaboraciones con Otros Artistas</span>
							    	<hr class="lfu-separador" style="border-top: 0px;">
									@foreach ( $cancionesArtistaPrincipalEnOtroDisco as $cancion )
										"<strong><a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a></strong>"
										@include('includes.imprimir_artistas_principales')
										<br>
									@endforeach
								</div>
							@endif
							<hr class="lfu-separador">
						@endif
					@endif

				</div>
			</div>
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12" >
		{{-- Sección de Comentarios --}}
		<div class="panel panel-primary artista-seccion-comentarios no-border-bottom" id="lfu-panel-artista-comentarios">
			<div class="panel-heading" id="lfu-artista-panel-heading-comentarios">
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

	{{-- <!--Prueba para el front-end-->
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>
     --}}

@endsection