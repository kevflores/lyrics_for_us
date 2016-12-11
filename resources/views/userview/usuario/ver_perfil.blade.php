@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

	@include('includes.bloque_de_mensajes')

	@if ( $usuarioPerfil->id !== Auth::User()->id )
		@include('includes.modal_crear_comentario')
		@include('includes.modal_enviar_mensaje_desde_perfil')
		@include('includes.modal_reportar_usuario')
	@endif

	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="lfu-seccion-completa col-xs-12">
	    	
	    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
	    		{{-- Sección de Datos --}}
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos">
						<strong>{{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}</strong>
					</div>
					<div class="panel-body" id="lfu-perfil-panel-body-datos">
						
						@if (Storage::disk('avatars')->has($usuarioPerfil->imagen))
				            <div class="imagen-perfil" style="margin-bottom:15px;">
				            	<span><img src="{{ route('usuario.avatar', ['imagenNombre' => $usuarioPerfil->imagen]) }}" alt="{{ $usuarioPerfil->nickname }}" class="img-responsive img-rounded lfu-avatar"></span>
				            </div> 
						@else
						 	<div class="imagen-perfil" style="margin-bottom:15px;">
								<span><img src="{{ asset('images\lfu-default-avatar.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
							</div> 
						@endif

						@if ( $usuarioPerfil->id == Auth::User()->id )
							<div class="enlace-editar"  style="margin-bottom:8px;">
								<a href="{{ route('usuario.configuracion') }}">Editar perfil</a> 
							</div>
						@endif
						<hr class="lfu-separador">
						<div class="perfil-dato-usuario"><i class="fa fa-user-circle-o lfu-fa-icon" aria-hidden="true"></i> {{ $usuarioPerfil->nickname }}</div>
						@if ( $usuarioPerfil->resumen )
							<div class="perfil-dato-usuario resumen-usuario"> "{{ $usuarioPerfil->resumen }}"</div>
						@endif
						@if ( $usuarioPerfil->ubicacion )
							<div class="perfil-dato-usuario"><i class="fa fa-map-marker lfu-fa-icon" aria-hidden="true"></i> {{ $usuarioPerfil->ubicacion }}</div>
						@endif
						@if ( $usuarioPerfil->url )
							<div class="perfil-dato-usuario"><i class="fa fa-link lfu-fa-icon" aria-hidden="true"></i> <a href="{{ $usuarioPerfil->url }}" title="{{ $usuarioPerfil->nickname.'\'s URL' }}">{{ $usuarioPerfil->url }}</a></div>
						@endif
						<div class="perfil-dato-usuario">Puntos: 0</div>	
						<hr class="lfu-separador">
					</div>
			    </div>
			    {{-- Sección de Opciones --}}
		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
					<div class="panel-body" id="lfu-perfil-panel-body-opciones">
						@if ( $usuarioPerfil->id === Auth::User()->id )
							<div class="perfil-opcion-usuario"><i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
							<a href="{{ route('usuario.ver_favoritos', ['nickname' => $usuarioPerfil->nickname]) }}">Ver mis favoritos</a></div>
						@else
							<div class="perfil-opcion-usuario">
								<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
								<a href="{{ route('usuario.ver_favoritos', ['nickname' => $usuarioPerfil->nickname]) }}">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a>
							</div>
							<div class="perfil-opcion-usuario">
								<i class="fa fa-paper-plane lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-escribir-mensaje-desde-perfil" style="cursor:pointer">Enviar mensaje privado</a>
							</div>
							<div class="perfil-opcion-usuario">
								<i class="fa fa-flag lfu-fa-icon" aria-hidden="true"></i> 
								<a id="lfu-reportar-usuario" style="cursor:pointer">Reportar usuario</a>
							</div>
						@endif
					</div>
			    </div>		    
	    	</div>

	    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
	    		{{-- Sección de Letras --}}
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras">Contribuciones</div>
					<div class="panel-body" id="lfu-perfil-panel-body-letras">
						
				    	@if ( $letrasProvistas->count() > 0 )
				    		<hr class="lfu-separador">
				    		@if ( $letrasProvistas->count() > 1 )
				    			@if ( $usuarioPerfil->id === Auth::User()->id )
				    				Tú has provisto las letras de las siguientes canciones:
				    			@else
				    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
				    			@endif
				    		@else
				    			@if ( $usuarioPerfil->id === Auth::User()->id )
				    				Tú has provisto la letra de una canción:
				    			@else
				    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
				    			@endif
				    		@endif
				    		<hr class="lfu-separador">
				    		<?php $fecha = null; ?>

					    	@foreach ( $letrasProvistas as $letraProvista )
					    		@if ( $fecha == null )
					    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
					    		@else
					    			@if ( $fecha == $letraProvista->fecha_letra )
					    				<hr class="lfu-separador-cancion-misma-fecha">
					    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
					    			@else
					    				<hr class="lfu-separador" >
					    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
						    			<hr class="lfu-separador" style="border-top: 0px;">
						    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
					    			@endif
					    		@endif
					            <?php $fecha = $letraProvista->fecha_letra; ?>
					        @endforeach
					        <hr class="lfu-separador">
					        
					    @else
					    	<hr class="lfu-separador">
					    	@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Aún no has provisto letras a canciones.
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
			    			@endif
					    	{{-- Mostrar Imagen --}}
					    	<hr class="lfu-separador">
				        @endif

				    	{{--<hr class="lfu-separador">--}}
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
						@if ( $usuarioPerfil->id !== Auth::User()->id )
							<a id="lfu-comentar" style="cursor:pointer">Comentar</a>
						@endif
						<div class="media" id="lfu-comentarios">
						@if ( $comentariosUsuario->count() > 0 )
							@foreach($comentariosUsuario as $comentario)
								<div class="media-left lfu-container-avatar-comentario">
									@if (Storage::disk('avatars')->has($comentario->imagen_usuario))
							            <img src="{{ route('usuario.avatar', ['imagenNombre' => $comentario->imagen_usuario]) }}" alt="{{ $comentario->nickname }}" class="img-circle media-object lfu-comentario-avatar">
									@else
										<img src="{{ asset('images\lfu-default-avatar.png') }}" alt="{{ $comentario->nickname }}" class="img-circle media-object lfu-comentario-avatar" >
									@endif
								</div>

								<div class="media-body lfu-comentario-individual">
									<strong class="media-heading lfu-comentario-autor">{{$comentario->nickname}} </strong> 
									<span style="font-style:italic;font-size:12px;">(El {{ date('d/m/Y', strtotime($comentario->fecha)) }} a las {{ date('H:m:s', strtotime($comentario->fecha)) }})</span>
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



	@else {{-- Sino, un guest/invitado está accediendo al perfil de un usuario  --}}

		<div class="lfu-seccion-completa col-xs-12">
	    	
	    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
	    		{{-- Sección de Datos --}}
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos">Datos</div>
					<div class="panel-body" id="lfu-perfil-panel-body-datos">
						Nickname: {{ $usuarioPerfil->nickname}}
						Foto:
						Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}
						Dirección URL:
						Puntos obtenidos:
						<hr>
						@for($i=0;$i<100;$i++)
					        Dato N° {{$i+1}}
					        <br>
				    	@endfor
				    	<hr>
					</div>
			    </div>
			    {{-- Sección de Opciones --}}
		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
					<div class="panel-body" id="lfu-perfil-panel-body-opciones">
						<a href="{{ route('usuario.ver_favoritos', ['nickname' => $usuarioPerfil->nickname]) }}">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a>
						<hr>
						@for($i=0;$i<100;$i++)
					        Opción N° {{$i+1}}
					        <br>
				    	@endfor
				    	<hr>
					</div>
			    </div>		    
	    	</div>

	    	<div class="lfu-seccion-dividida col-xs-12 col-sm-8"  style="">
	    		{{-- Sección de Letras --}}
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras">Letras</div>
					<div class="panel-body" id="lfu-perfil-panel-body-letras">
						Ver listado de canciones cuyas letras fueron provistas por el usuario.
						<hr>
						@for($i=0;$i<100;$i++)
					        Canción N° {{$i+1}}
					        <br>
				    	@endfor
				    	<hr>
					</div>
				</div>
	    	</div>

		</div>

		<div class="lfu-seccion-completa col-xs-12" >
			{{-- Sección de Comentarios --}}
			<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-panel-comentarios">
				<div class="panel-heading" id="lfu-panel-heading-comentarios">
					<a data-toggle="collapse" class="ver-comentarios" href="#lfu-panel-collapse-comentarios">Mostrar comentarios</a>
					<a data-toggle="collapse" class="ocultar-comentarios" href="#lfu-panel-collapse-comentarios">Ocultar comentarios</a>
				</div>
				<div id="lfu-panel-collapse-comentarios" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="media" id="lfu-comentarios">
							
							<div class="media-left">
								<img src="{{ asset('images\eunjung_avatar.jpg') }}" class="img-circle media-object lfu-comentario-avatar">
							</div>
							<div class="media-body lfu-comentario-individual">
								<strong class="media-heading lfu-comentario-autor">Nickname de usuario (fecha)</strong>
								<p id="lfu-comentario-descripcion">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
							<hr class="lfu-separador-comentarios">
							<div class="media-left">
								<img src="{{ asset('images\siwon_avatar.png') }}" class="img-circle media-object lfu-comentario-avatar">
							</div>
							<div class="media-body lfu-comentario-individual">
								<strong class="media-heading lfu-comentario-autor">Nickname de usuario (fecha)</strong>
								<p id="lfu-comentario-descripcion">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	@endif  

	{{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>

@endsection