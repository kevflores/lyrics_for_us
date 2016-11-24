@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Perfil</h3>
	
	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="col-md-12" style="padding-left:0;padding-right:0;">
	    	
	    	<div class="col-md-4" style="padding-left:0;padding-right:0;;">
		    	<div class="panel panel-primary perfil-seccion-datos" id="lfu-panel" style="height:350px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Datos</div>
					<div class="panel-body">
						<ul>
							@if ( $usuarioPerfil->id == Auth::User()->id )
								<li><a href="#">Editar</a></li>
							@endif
							<li>Nickname: {{ $usuarioPerfil->nickname}}</li>
							<li>Foto:</li>
							<li>Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}</li>
							<li>Dirección URL:</li>
							<li>Puntos obtenidos:</li>
						</ul>
					</div>
			    </div>

		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-panel" style="height:150px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Opciones</div>
					<div class="panel-body">
						<ul>
							<li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
							@if ( $usuarioPerfil->id != Auth::User()->id )
								<li><a href="#">Enviar mensaje privado</a></li>
								<li><a href="#">Reportar</a></li>
							@endif
						</ul>
					</div>
			    </div>		    
	    	</div>

	    	<div class="col-md-8" style="padding-left:0;padding-right:0;padding-bottom:0">
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-panel" style="height:500px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Letras</div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="col-md-12" style="padding-left:0;padding-right:0;padding-bottom:0">
			<div class="panel panel-primary perfil-seccion-comentarios" id="lfu-panel" style="margin-bottom:0px;">
				<div class="panel-heading" id="lfu-panel-heading">Comentarios</div>
				<div class="panel-body">
				<ul>
					<li><a href="#">Ver comentarios</a></li>
					<li><a href="#">Comentar</a></li>
				</ul>
				</div>
			</div>
		</div>

	@else {{-- Sino, un guest/invitado está accediendo al perfil de un usuario  --}}

	<div class="col-md-12" style="padding-left:0;padding-right:0;">
	    	
	    	<div class="col-md-4" style="padding-left:0;padding-right:0;;">
		    	<div class="panel panel-primary perfil-seccion-datos" id="lfu-panel" style="height:350px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Datos</div>
					<div class="panel-body">
						<ul>
							<li>Nickname: {{ $usuarioPerfil->nickname}}</li>
							<li>Foto:</li>
							<li>Nombre: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido}}</li>
							<li>Dirección URL:</li>
							<li>Puntos obtenidos:</li>
						</ul>
					</div>
			    </div>

		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-panel" style="height:150px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Opciones</div>
					<div class="panel-body">
						<ul>
							<li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
						</ul>
					</div>
			    </div>		    
	    	</div>

	    	<div class="col-md-8" style="padding-left:0;padding-right:0;padding-bottom:0">
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-panel" style="height:500px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-panel-heading">Letras</div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="col-md-12" style="padding-left:0;padding-right:0;">
			<div class="panel panel-primary perfil-seccion-comentarios" id="lfu-panel" style="margin-bottom:0px;">
				<div class="panel-heading" id="lfu-panel-heading">Comentarios</div>
				<div class="panel-body">
				<ul>
					<li><a href="#">Ver comentarios</a></li>
				</ul>
				</div>
			</div>
		</div>
		
	</div>

	@endif
    
@endsection