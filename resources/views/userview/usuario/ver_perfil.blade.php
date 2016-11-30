@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="lfu-seccion-completa col-xs-12">
	    	
	    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
	    		{{-- Sección de Datos --}}
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos">Datos</div>
					<div class="panel-body" id="lfu-perfil-panel-body-datos">
						@if ( $usuarioPerfil->id == Auth::User()->id )
							<a href="#">Editar</a>
						@endif
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
						@if ( $usuarioPerfil->id != Auth::User()->id )
							<a href="#">Enviar mensaje privado</a>
							<a href="#">Reportar</a>
						@endif
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
						<a id="lfu-comentar" style="cursor:pointer">Comentar</a>
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

		<!-- Modal para crear comentario en el perfil del usuario -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			<!-- Contenido del Modal-->
				<div class="modal-content">
					<div class="modal-header" >
						<button type="button" class="close cerrar_modal" data-dismiss="modal">&times;</button>
						<h4><span class="glyphicon glyphicon-pencil"></span> Comentar en el perfil de {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}</h4>
					</div>
					<div class="modal-body" >
						<form action="{{ route('usuario.comentar', ['id_usuario' => $usuarioPerfil->id]) }}" method="post">
							{!! csrf_field() !!}
							<div class="form-group">
								<textarea rows="8" cols="50" id="lfu-textarea-comentario" placeholder="Ingresar comentario..."></textarea>
							</div>
							<button type="button" class="btn btn-danger" id="cancelar-comentario" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="enviar-comentario" >Enviar</button>
						</form>
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