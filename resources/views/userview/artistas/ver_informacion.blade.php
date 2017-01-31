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
					
					
					<hr class="lfu-separador">
				</div>
		    </div>
		    {{-- Sección de Opciones --}}
	    	<div class="panel panel-primary artista-seccion-popularidad" id="lfu-artista-panel-popularidad">
				<div class="panel-heading" id="lfu-artista-panel-heading-popularidad">Popularidad</div>
				<div class="panel-body" id="lfu-artista-panel-body-popularidad">
					<div class="artista-cantidad-favoritos">
						A 10 usuarios les gusta {{ $artista->nombre }}
					</div>
					@if ($usuario)
						<div class="artista-opcion">
							<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
							<a href="#">Agregar a mis artistas favoritos</b></a>
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

					{{-- Si el artista tiene discos... --}}
					{{-- COLOCAR CADA UNO EN UN WELL O ALGO ASÍ--}}
					@if ( count($artista->discos) )
						<div class="">
							<span class="label label-info">Discos</span>
					    	<hr class="lfu-separador" style="border-top: 0px;">
					    	@foreach ( $artista->discos()->orderBy('fecha', 'desc')->get() as $disco )
							<div>
								<div>
									<strong>"<a class="lfu-enlace-sin-decoracion lfu-texto-italic" data-toggle="collapse" href="#collapse{{ $disco->id }}">{{ $disco->titulo }}</a>"</strong> ({{ date('Y', strtotime($disco->fecha))}})
								</div>
								{{-- Y se muestran las canciones que pertenecen al disco --}}
								<div id="collapse{{ $disco->id }}" class="collapse">
									<a href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}" title="">Ver información</a>
									<br>
									@if ( count((App\Disco::find($disco->id)->canciones)) )
										Lista de canciones:
										<hr class="lfu-separador-cancion-misma-fecha">
										@foreach ( (App\Disco::find($disco->id)->canciones()->orderBy('numero')->get()) as $cancion )
											<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}" title=""><span class="lfu-texto-italic">{{ $cancion->titulo }}</span></a>
											<hr class="lfu-separador-cancion-misma-fecha">
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
			    	@endif

			    	{{-- Si el artista tiene canciones que no están incluidas en ningún disco... --}}
			    	@if ( count($artista->canciones->where('pivot.invitado', FALSE)->where('disco_id', NULL)) )
			    	Canciones sin disco
			    	<br>
			    	<br>
			    		@foreach ( $artista->canciones->where('pivot.invitado', FALSE)->where('disco_id', NULL) as $cancion )
			    			"{{ $cancion->titulo }}"
			    		@endforeach
			    	<br>
			    	<br>
			    	@endif
			    	
			    	{{-- Si el artista ha colaborado como invitado en canciones de otros artistas... --}}
			    	@if ( count($artista->canciones->where('pivot.invitado', TRUE)) )
			    	Colaboraciones
			    	<br>
			    	<br>
			    		@foreach ( $artista->canciones->where('pivot.invitado', TRUE) as $cancion )
			    			"{{ $cancion->titulo }}"
			    		@endforeach
			    	<br>
			    	<br>
			    	@endif
			        
				</div>
			</div>
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12" >
		{{-- Sección de Comentarios --}}
		<div class="panel panel-primary artista-seccion-comentarios no-border-bottom" id="lfu-panel-comentarios">
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