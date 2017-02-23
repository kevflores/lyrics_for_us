@extends('layouts.master_usuario')

@section('titulo')
	@if ( $usuarioPerfil )
    	{{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}} ({{ $usuarioPerfil->nickname }})
    @else
    	Usuario Equivocado
    @endif
     | Lyrics For Us
@endsection

@section('contenido')

	@if ( $usuarioPerfil )

		@include('includes.bloque_de_mensajes')

		@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}
			@include('includes.modal_crear_comentario')
			@if ( $usuarioPerfil->id !== Auth::User()->id )
				@include('includes.modal_enviar_mensaje_desde_perfil')
				@include('includes.modal_reportar_usuario')
			@endif
		@endif

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

						@if ($usuario)
							@if ( $usuarioPerfil->id === $usuario->id )
								<div class="enlace-editar"  style="margin-bottom:8px;">
									<a href="{{ route('usuario.configuracion') }}">Editar perfil</a> 
								</div>
							@endif
						@endif

						<hr class="lfu-separador">
						
						<div class="perfil-dato-usuario">
							<strong>
								<i class="fa fa-user-circle-o lfu-fa-icon" aria-hidden="true"></i>
								{{ $usuarioPerfil->nickname }} 
							</strong>
						</div>
						@if ( $usuarioPerfil->resumen )
							<div class="perfil-dato-usuario resumen-usuario"> "{{ $usuarioPerfil->resumen }}"</div>
						@endif
						@if ( $usuarioPerfil->ubicacion )
							<div class="perfil-dato-usuario"><i class="fa fa-map-marker lfu-fa-icon" aria-hidden="true"></i> {{ $usuarioPerfil->ubicacion }}</div>
						@endif
						@if ( $usuarioPerfil->url )
							<div class="perfil-dato-usuario"><i class="fa fa-link lfu-fa-icon" aria-hidden="true"></i> <a href="{{ $usuarioPerfil->url }}" title="{{ $usuarioPerfil->nickname.'\'s URL' }}">{{ $usuarioPerfil->url }}</a></div>
						@endif
						<div class="perfil-dato-usuario">Puntos: 0 (Falta calcular)</div>	
						<hr class="lfu-separador">
					</div>
			    </div>
			    {{-- Sección de Opciones --}}
		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
					<div class="panel-body" id="lfu-perfil-panel-body-opciones">
						@if ($usuario)
							@if ( $usuarioPerfil->id === $usuario->id )
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
						@else
							<div class="perfil-opcion-usuario">
								<i class="fa fa-star lfu-fa-icon" aria-hidden="true"></i> 
								<a href="{{ route('usuario.ver_favoritos', ['nickname' => $usuarioPerfil->nickname]) }}">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a>
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
				    			@if ( $usuario )
					    			@if ( $usuarioPerfil->id === $usuario->id )
					    				Tú has provisto las letras de las siguientes canciones:
					    			@else
					    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
					    			@endif
					    		@else
					    			<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
					    		@endif
				    		@else
				    			@if ( $usuario )
					    			@if ( $usuarioPerfil->id === $usuario->id )
					    				Tú has provisto la letra de una canción:
					    			@else
					    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
					    			@endif
					    		@else
					    			<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
					    		@endif
				    		@endif
				    		<hr class="lfu-separador">
				    		
				    		<?php $fecha = null;?>
				    		{{-- Se imprime el listado de las canciones, agrupándolas por fecha en la cual el usuario proveyó la letra --}}
					    	@foreach ( $letrasProvistas as $letraProvista )
					    		@if ( $fecha === null )
					    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			@include('includes.imprimir_listado_letras_provistas')
					    		@else
					    			@if ( $fecha === $letraProvista->fecha_letra )
					    				<hr class="lfu-separador-cancion-misma-fecha">
					    				@include('includes.imprimir_listado_letras_provistas')
					    			@else
					    				<hr class="lfu-separador" >
					    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
						    			<hr class="lfu-separador" style="border-top: 0px;">
					    				@include('includes.imprimir_listado_letras_provistas')
					    			@endif
					    		@endif
					            <?php $fecha = $letraProvista->fecha_letra; ?>
					        @endforeach
					        <hr class="lfu-separador">
					    @else
					    	<hr class="lfu-separador">
					    	@if ( $usuario )
						    	@if ( $usuarioPerfil->id === $usuario->id )
				    				Aún no has provisto letras a canciones.
				    			@else
				    				<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
				    			@endif
				    		@else
				    			<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
				    		@endif
					    	{{-- Mostrar Imagen alusiva a no haber colaborado con letras AQUÍ--}}
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
						@if ( $usuario )
							<a id="lfu-comentar" style="cursor:pointer">Comentar</a>
						@endif
						<div class="media" id="lfu-comentarios">
						@if ( $comentariosUsuario->count() > 0 )
							@foreach($comentariosUsuario as $comentario)
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
										@if ($comentario->usuario_emisor_id === $usuario->id)
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

	@else

		<div class="lfu-seccion-completa col-xs-12">
	    	<div class="panel panel-primary" id="lfu-panel-default">
				<div class="panel-heading" id="lfu-panel-heading-default">¿Usuario equivocado?</div>
				<div class="panel-body" id="lfu-panel-body-default">
					<div class="imagen-perfil" style="margin-bottom:15px;">
						<span><img src="{{ asset('images\lfu-default-avatar.png') }}" class="img-responsive img-rounded lfu-avatar"></span>
					</div> 
	                <p style="margin-bottom:15px;">Este usuario no existe.</p>
				</div>
			</div>
		</div>

		<div class="lfu-seccion-completa col-xs-12">
			<div class="panel panel-primary panel-footer-configuracion">
				<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
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