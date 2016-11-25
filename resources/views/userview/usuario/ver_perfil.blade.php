@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

	@if ($usuario) {{-- Si un usuario autenticado está accediendo al perfil --}}

		<div class="lfu-seccion-completa col-md-12">
	    	
	    	<div class="lfu-seccion-dividida col-md-4">
	    		{{-- Sección de Datos --}}
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos">Datos</div>
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
			    {{-- Sección de Opciones --}}
		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
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

	    	<div class="lfu-seccion-dividida col-md-8" style="">
	    		{{-- Sección de Letras --}}
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras">Letras</div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="lfu-seccion-completa col-md-12" >
			{{-- Sección de Comentarios --}}
			<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-panel-comentarios">
				<div class="panel-heading" id="lfu-panel-heading-comentarios">
					<a data-toggle="collapse" class="ver-comentarios" href="#lfu-panel-collapse-comentarios">Ver comentarios</a>
					<a data-toggle="collapse" class="ocultar-comentarios" href="#lfu-panel-collapse-comentarios">Ocultar comentarios</a>
				</div>
				<div id="lfu-panel-collapse-comentarios" class="panel-collapse collapse">
					<div class="panel-body">
						<a href="#" id="lfu-comentar">Comentar</a></li>
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Comentar en el perfil de {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}</h4>
        </div>
        <div class="modal-body" >
          <form action="{{ route('usuario.comentar', ['id_usuario' => $usuarioPerfil->id]) }}" method="post">
          	{!! csrf_field() !!}
            <div class="form-group">
              <textarea rows="8" cols="50" placeholder="Ingrese comentario..." style="width:100%;"></textarea>
            </div>
            	<button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
      </div>
      
    </div>
  </div> 

	@else {{-- Sino, un guest/invitado está accediendo al perfil de un usuario  --}}

		<div class="lfu-seccion-completa col-md-12">
	    	
	    	<div class="lfu-seccion-dividida col-md-4">
		    	<div class="panel panel-primary" id="lfu-perfil-panel-datos">
					<div class="panel-heading" id="lfu-perfil-panel-heading-datos">Datos</div>
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

		    	<div class="panel panel-primary perfil-seccion-opciones" id="lfu-perfil-panel-opciones">
					<div class="panel-heading" id="lfu-perfil-panel-heading-opciones">Opciones</div>
					<div class="panel-body">
						<ul>
                            <li><a href="#">Ver favoritos de <b>{{ $usuarioPerfil->nickname}}</b></a></li>
						</ul>
					</div>
			    </div>		    
	    	</div>

	    	<div class="lfu-seccion-dividida col-md-8" style="">
		    	<div class="panel panel-primary perfil-seccion-letras" id="lfu-perfil-panel-letras" style="">
					<div class="panel-heading" id="lfu-perfil-panel-heading-letras">Letras</div>
					<div class="panel-body">
					<ul>
						<li>Ver listado de canciones cuyas letras fueron provistas por el usuario.</li>
					</ul>
					</div>
				</div>
	    	</div>

		</div>

		<div class="lfu-seccion-completa col-md-12" >
			<div class="panel panel-primary perfil-seccion-comentarios no-border-bottom" id="lfu-panel-comentarios">
				<div class="panel-heading" id="lfu-panel-heading-comentarios">
					<a data-toggle="collapse" class="ver-comentarios" href="#lfu-panel-collapse-comentarios">Ver comentarios</a>
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
@endsection