@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

@include('includes.bloque_de_mensajes')
@include('includes.modal_eliminar_favorito')
    
	<div class="lfu-seccion-completa col-xs-12" >
		<div class="panel panel-primary" id="lfu-panel-usuario-favoritos">
			<div class="panel-heading" id="lfu-panel-usuario-favoritos-heading" style="
			border-bottom:0px;">
				<strong>
				@if ( $usuario )
					@if ($usuarioFavoritos->id === Auth::User()->id )
						Mis Favoritos
					@else
						Favoritos de {{ $usuarioFavoritos->nombre.' '.$usuarioFavoritos->apellido }} 
						(<a class="lfu-enlace-sin-decoracion" style="color:white;" href="{{ route('usuario.perfil', ['nickname' => $usuarioFavoritos->nickname]) }}">{{ $usuarioFavoritos->nickname }}</a>)
					@endif
				@else
					Favoritos de {{ $usuarioFavoritos->nombre.' '.$usuarioFavoritos->apellido }} 
					(<a class="lfu-enlace-sin-decoracion" style="color:white;" href="{{ route('usuario.perfil', ['nickname' => $usuarioFavoritos->nickname]) }}" style="color:white;">{{ $usuarioFavoritos->nickname }}</a>)
				@endif
				</strong>
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
	    	
    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
	    	<div class="panel panel-primary" id="lfu-panel-artistas-favoritos" style="">
				<div class="panel-heading" id="lfu-panel-heading-artistas-favoritos">Artistas</div>
				<div class="panel-body" id="lfu-panel-body-artistas-favoritos">
					
					@if ( is_obj_empty($artistasFavoritos) )
						<hr class="lfu-separador">
						@foreach ( $artistasFavoritos as $artista)
							<span class="lfu-artista-favorito" data-idfavorito="{{ $artista->pivot->id }}" data-nombreartista="{{ $artista->nombre }}">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">{{ $artista->nombre }}</a>
								@if ( $usuario )
				    				@if ( $usuarioFavoritos->id === $usuario->id )
										<a class="eliminar-artista-favorito" style="cursor: pointer;"><i class="fa fa-trash eliminar-favorito" aria-hidden="true" title="Eliminar favorito"></i></a>
									@endif
								@endif
							</span>
							<hr class="lfu-separador">
						@endforeach
					@else
						<hr class="lfu-separador">
				    	@if ( $usuario )
				    		@if ( $usuarioFavoritos->id === $usuario->id )
		    					Aún no posees artistas favoritos.
		    				@else
		    					<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee artistas favoritos.
		    				@endif
		    			@else
		    				<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee artistas favoritos.
		    			@endif
				    	{{-- Mostrar Imagen alusiva a no poseer artistas favoritos AQUÍ--}}
				    	<hr class="lfu-separador">
					@endif
			    	
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
	    	<div class="panel panel-primary" id="lfu-panel-discos-favoritos" style="">
				<div class="panel-heading" id="lfu-panel-heading-discos-favoritos">Discos</div>
				<div class="panel-body" id="lfu-panel-body-discos-favoritos">
					
					@if ( $discosFavoritos->count() > 0 )
						<hr class="lfu-separador">
						@foreach ( $discosFavoritos as $disco)
							<span class="lfu-disco-favorito" data-idfavorito="{{ $disco->id }}" data-titulodisco="{{ $disco->titulo }}">
								<span class="lfu-texto-italic">
									<a class="lfu-enlace-sin-decoracion" href="{{ route('discos.informacion', ['id_disco' => $disco->disco_id]) }}">
										"{{ $disco->titulo }}"
									</a>
								</span> de 
								<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $disco->artista_id]) }}">
									{{ $disco->nombreArtista }}
								</a>
									@if ( $usuario )
					    				@if ( $usuarioFavoritos->id === $usuario->id )
											<a class="eliminar-disco-favorito" style="cursor: pointer;"><i class="fa fa-trash eliminar-favorito" aria-hidden="true" title="Eliminar favorito"></i></a>
										@endif
									@endif
							</span>
							<hr class="lfu-separador">
						@endforeach
					@else
						<hr class="lfu-separador">
				    	@if ( $usuario )
		    				@if ( $usuarioFavoritos->id === $usuario->id )
		    					Aún no posees discos favoritos.
		    				@else
		    					<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee discos favoritos.
		    				@endif
		    			@else
		    				<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee discos favoritos.
		    			@endif
				    	{{-- Mostrar Imagen alusiva a no poseer discos favoritos AQUÍ--}}
				    	<hr class="lfu-separador">
					@endif
			    	
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
	    	<div class="panel panel-primary" id="lfu-panel-canciones-favoritas" style="">
				<div class="panel-heading" id="lfu-panel-heading-canciones-favoritas">Canciones</div>
				<div class="panel-body" id="lfu-panel-body-canciones-favoritas">
					
			    	@if ( is_obj_empty($cancionesFavoritas) )
						<hr class="lfu-separador">
						@foreach ( $cancionesFavoritas as $cancion)
							<span class="lfu-cancion-favorita" data-idfavorito="{{ $cancion->pivot->id }}" data-titulocancion="{{ $cancion->titulo }}">
								<span class="lfu-texto-italic">
									<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
										"{{ $cancion->titulo }}"
									</a>
								</span>
								<?php 
									$artistasPrincipales = $cancion->artistas()->where('invitado', false)->orderBy('nombre')->get();
									$artistasInvitados = $cancion->artistas()->where('invitado', true)->orderBy('nombre')->get();  
								?>
								@if ( $artistasPrincipales->count() > 1 )
									de 
									<?php $primero = true; ?>
									@foreach ( $artistasPrincipales as $artista )
										@if ( $primero === true)
											<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
												{{$artista->nombre}}
											</a>
										@else
											& <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
												{{$artista->nombre}}
											</a>
										@endif
										<?php $primero = false; ?>
									@endforeach
								@else
									@foreach ( $artistasPrincipales as $artista )
										de <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
											{{ $artista->nombre }}
										</a>
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
								@if ( $usuario )
				    				@if ( $usuarioFavoritos->id === $usuario->id )
										<a class="eliminar-cancion-favorita" style="cursor: pointer;"><i class="fa fa-trash eliminar-favorito" aria-hidden="true" title="Eliminar favorito"></i></a>
									@endif
								@endif
							</span>
							<hr class="lfu-separador">
						@endforeach
					@else
						<hr class="lfu-separador">
				    	@if ( $usuario )
		    				@if ( $usuarioFavoritos->id === $usuario->id )
		    					Aún no posees canciones favoritas.
		    				@else
		    					<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee canciones favoritas.
		    				@endif
		    			@else
		    				<strong>{{ $usuarioFavoritos->nickname }}</strong> aún no posee canciones favoritas.
		    			@endif
				    	{{-- Mostrar Imagen alusiva a no poseer canciones favoritas AQUÍ--}}
				    	<hr class="lfu-separador">
					@endif

				</div>
			</div>
    	</div>

	</div>
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary panel-footer-configuracion">
			<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
		</div>
	</div>

	<script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('eliminar_favorito') }}';
    </script>
@endsection