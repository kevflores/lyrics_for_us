@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="col-md-12" style="padding-left:0;padding-right:0;">
	    	
	    	<div class="col-md-4" style="padding-left:0;padding-right:0;;">
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos" style="height:350px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos"><strong>Datos</strong></div>
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

		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones" style="height:150px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones"><strong>Opciones</strong></div>
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
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="height:500px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras"><strong>Letras</strong></div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="col-md-12" style="padding-left:0;padding-right:0;padding-bottom:0">
			<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-perfil-panel-comentarios" >
				<div class="panel-heading" id="lfu-perfil-panel-heading-comentarios">
					<a data-toggle="collapse" href="#lfu-perfil-panel-collapse-comentarios"><strong>Ver comentarios</strong></a>
				</div>
				<div id="lfu-perfil-panel-collapse-comentarios" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							<li><a href="#">Comentar</a></li>
						</ul>

						<div class="media" id="lfu-perfil-comentarios">
							
							<div class="media-left">
								<img src="{{ asset('images\eunjung_avatar.jpg') }}" class="img-circle media-object" style="width:60px;height:60px;">
							</div>
							<div class="media-body" style="text-align:left;">
								<strong class="media-heading">Nickname de usuario (fecha)</strong>
								<p id="lfu-perfil-comentario-individual">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
							<hr style="margin-top:0px; margin-bottom:13px;">
							<div class="media-left">
								<img src="{{ asset('images\siwon_avatar.png') }}" class="img-circle media-object" style="width:60px">
							</div>
							<div class="media-body" style="text-align:left;">
								<strong class="media-heading">Nickname de usuario (fecha)</strong>
								<p id="lfu-perfil-comentario-individual">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	@else {{-- Sino, un guest/invitado está accediendo al perfil de un usuario  --}}

		<div class="col-md-12" style="padding-left:0;padding-right:0;">
	    	
	    	<div class="col-md-4" style="padding-left:0;padding-right:0;;">
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos" style="height:350px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos"><strong>Datos</strong></div>
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

		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones" style="height:150px;margin-bottom:0px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones"><strong>Opciones</strong></div>
					<div class="panel-body">
						<ul>
							<li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
						</ul>
					</div>
			    </div>		    
	    	</div>

	    	<div class="col-md-8" style="padding-left:0;padding-right:0;padding-bottom:0">
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="height:500px;">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras"><strong>Letras</strong></div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="col-md-12" style="padding-left:0;padding-right:0;padding-bottom:0">
			<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-perfil-panel-comentarios" >
				<div class="panel-heading" id="lfu-perfil-panel-heading-comentarios">
					<a data-toggle="collapse" href="#lfu-perfil-panel-collapse-comentarios"><strong>Ver comentarios</strong></a>
				</div>
				<div id="lfu-perfil-panel-collapse-comentarios" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="media" id="lfu-perfil-comentarios">
							
							<div class="media-left">
								<img src="{{ asset('images\eunjung_avatar.jpg') }}" class="img-circle media-object" style="width:60px;height:60px;">
							</div>
							<div class="media-body" style="text-align:left;">
								<strong class="media-heading">Nickname de usuario (fecha)</strong>
								<p id="lfu-perfil-comentario-individual">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
							<hr style="margin-top:0px; margin-bottom:13px;">
							<div class="media-left">
								<img src="{{ asset('images\siwon_avatar.png') }}" class="img-circle media-object" style="width:60px">
							</div>
							<div class="media-body" style="text-align:left;">
								<strong class="media-heading">Nickname de usuario (fecha)</strong>
								<p id="lfu-perfil-comentario-individual">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	@endif  
@endsection