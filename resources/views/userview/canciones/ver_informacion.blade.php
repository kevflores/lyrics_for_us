@extends('layouts.master_usuario')

@section('titulo')
    Canción: "{{ $cancion->titulo }}" | Lyrics For Us
@endsection

@section('contenido')
    
	@if ($usuario) {{-- Si un usuario autenticado está accediendo a la información de una Canción --}}
		@include('includes.bloque_de_mensajes')
		@include('includes.modal_comentar_cancion')
	@endif

	<div class="lfu-seccion-completa col-xs-12">
    	
    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de Datos del Canción--}}
	    	<div class="panel panel-primary" id="lfu-cancion-panel-datos">
				<div class="panel-heading" id="lfu-cancion-panel-heading-datos">
					<strong>Canción</strong>
				</div>
				<div class="panel-body" id="lfu-cancion-panel-body-datos">
					
					@if (Storage::disk('img-canciones')->has($cancion->portada))
			            <div class="imagen-cancion" style="margin-bottom:15px;">
			            	<span><img src="{{ route('canciones.imagen', ['imagenNombre' => $cancion->portada]) }}" alt="{{ $cancion->titulo }}" class="img-responsive img-rounded lfu-avatar"></span>
			            </div> 
					@else
					 	<div class="imagen-cancion" style="margin-bottom:15px;">
							<span><img src="{{ asset('images\lfu-default-cancion.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
						</div> 
					@endif

					<hr class="lfu-separador">

					<div class="cancion-dato">
						<strong>
							<i class="fa fa-music lfu-fa-icon" aria-hidden="true"></i>
							"{{ $cancion->titulo }}"
						</strong>

						@if ( $artistasPrincipales->count() > 1 )
							de 
							<?php $primerArtista = true; ?>
							@foreach ( $artistasPrincipales as $artista )
								@if ( $primerArtista === true)
									<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
								@else
									& <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
								@endif
								<?php $primerArtista = false; ?>
							@endforeach
						@else
							@foreach ( $artistasPrincipales as $artista )
								de <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
							@endforeach
						@endif

						@if ( $artistasInvitados->count() > 1 )
							<?php
								$primerArtista = true;
								foreach ( $artistasInvitados as $artista ) {
									if ( $primerArtista === true)
										$invitados = $artista->nombre;
									else
										$invitados= $invitados." & ".$artista->nombre;
									$primerArtista = false;
								}
							?>
							(feat. {{$invitados}})
						@else
							@foreach ( $artistasInvitados as $artista )
								(feat. {{ $artista->nombre }})
							@endforeach
						@endif

					</div>

					@if ( $cancion->disco_id )
						<div class="cancion-dato">
							<i class="fa fa-play lfu-fa-icon" aria-hidden="true"></i>
							<a class="lfu-enlace-sin-decoracion" href="{{ route('discos.informacion', ['id_disco' => $cancion->disco_id]) }}" title="">"{{$cancion->disco()->first()->titulo}}" ({{ date('Y', strtotime($cancion->disco()->first()->fecha)) }})</a>
						</div>
					@endif

					@if ( $cancion->resumen )
						<div class="cancion-dato resumen-cancion"> "{{ $cancion->resumen }}"</div>
					@endif

					{{-- <!-- Código para actualizar la portada del cancion [SE DEBE USAR al momento de implementar la función del Administrador] -->
					<form action="{{ route('canciones.actualizar_imagen', ['id_cancion' => $cancion->id]) }}" method="post", id='lfu-form-config-imagen' enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="form-group col-xs-12 {{ $errors->has('imagen') ? 'has-error' : '' }}">
							<div class="form-control seleccionarImagen">
							    <span class="spanImagen">Seleccionar imagen</span>
							    <input type="file" name="imagen" class="subirImagen"/>
							</div>
        				</div>
						<button type="submit" class="btn btn-primary">Subir nueva imagen</button>
					</form>
					--}}
					
					<hr class="lfu-separador">
				</div>
		    </div>
		    {{-- Sección de Opciones --}}
	    	<div class="panel panel-primary cancion-seccion-popularidad" id="lfu-cancion-panel-popularidad">
				<div class="panel-heading" id="lfu-cancion-panel-heading-popularidad">Popularidad</div>
				<div class="panel-body" id="lfu-cancion-panel-body-popularidad">
					
					@if ( $usuario )
						@if ( count($usuarioFavorito) )
							<div class="cancion-cantidad-favoritos">
								@if ( $numeroFavoritos === 1 )
									"{{ $cancion->titulo }}" es una de tus canciones favoritas
								@elseif ( $numeroFavoritos === 2 )
									Tú y otro usuario tienen a "{{ $cancion->titulo }}" en su lista de canciones favoritas
								@else 
									Tú y <strong>{{ $numeroFavoritos }}</strong> usuarios tienen a "{{ $cancion->titulo }}" en su lista de canciones favoritas
								@endif
							</div>
							<div class="cancion-opcion">
								<i class="fa fa-minus-circle lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-eliminar-cancion-favoritos" style="cursor:pointer">
									Eliminar de mi lista de canciones favoritas
								</a>
								<form action="{{ route('canciones.favorita') }}" id="lfu-eliminar-cancion-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_cancion" value="{{ $cancion->id }}">
									<input type="hidden" name="opcion" value="eliminar">
								</form>
							</div>
						@else
							<div class="cancion-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									"{{ $cancion->titulo }}" aún no ha sido agregada a una lista de canciones favoritas
								@elseif ( $numeroFavoritos === 1)
									"{{ $cancion->titulo }}" es una de las canciones favoritas de un usuario
								@else
									"{{ $cancion->titulo }}" es una de las canciones favoritas de <strong>{{ $numeroFavoritos }}</strong> usuarios
								@endif
							</div>
							<div class="cancion-opcion">
								<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-agregar-cancion-favoritos" style="cursor:pointer">
									Agregar a mi lista de canciones favoritas
								</a>
								<form action="{{ route('canciones.favorita') }}" id="lfu-agregar-cancion-favoritos-form" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id_cancion" value="{{ $cancion->id }}">
									<input type="hidden" name="opcion" value="agregar">
								</form>
							</div>
						@endif
					@else
						<div class="cancion-cantidad-favoritos">
								@if ( $numeroFavoritos === 0)
									"{{ $cancion->titulo }}" aún no ha sido agregada a una lista de canciones favoritas
								@elseif ( $numeroFavoritos === 1)
									"{{ $cancion->titulo }}" es una de las canciones favoritas de un usuario
								@else
									"{{ $cancion->titulo }}" es una de las canciones favoritas de <strong>{{ $numeroFavoritos }}</strong> usuarios
								@endif
							</div>
					@endif
				</div>
		    </div>		    
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
    		{{-- Sección de la letra de la cancion --}}
	    	<div class="panel panel-primary cancion-seccion-canciones" id="lfu-cancion-panel-canciones">
				<div class="panel-heading" id="lfu-cancion-panel-heading-canciones">Letra de "{{ $cancion->titulo }}"</div>
				<div class="panel-body" id="lfu-cancion-panel-body-canciones">

					@if ( $cancion->letra ) 
						<hr class="lfu-separador">
						{{-- Se usa la función "nl2br" para que muestre los saltos de línea --}}
						<?php echo nl2br($cancion->letra); ?>
						<hr class="lfu-separador">
					@else
						{{-- Si el cancion tiene canciones... --}}
						<hr class="lfu-separador">
						La letra de esta canción aún no ha sido registrada.
						<br />
						 ¿Deseas compartirla con nosotros?
						<span style="font-style:italic;color:red;">(Mostrar imagen)</span>
						{{-- Mostrar alguna imagen alusiva --}}
						<hr class="lfu-separador">
					@endif

				</div>
			</div>
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12" >
		{{-- Sección de Comentarios --}}
		<div class="panel panel-primary cancion-seccion-comentarios no-border-bottom" id="lfu-panel-cancion-comentarios">
			<div class="panel-heading" id="lfu-cancion-panel-heading-comentarios">
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
					@if ( $comentariosCancion->count() > 0 )
						@foreach($comentariosCancion as $comentario)
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