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
				@if ( $reporteComprobacion->count() === 0 )
					{{-- Si el usuario autenticado no ha realizado un reporte sobre el usuario del perfil que aún no haya sido atendido --}}
					@include('includes.modal_reportar_usuario')
				@endif
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
						<div class="perfil-dato-usuario">
							<i class="fa fa-eye lfu-fa-icon" aria-hidden="true"></i>
							{{ $usuarioPerfil->visitas }}
							@if ( $usuarioPerfil->visitas > 1)
								visitas
							@elseif ($usuarioPerfil->visitas == 1)
								1 visita
							@else
								Sin visitas
							@endif
						</div>
						<div class="perfil-dato-usuario">
							<i class="fa fa-line-chart lfu-fa-icon" aria-hidden="true"></i>
							@if ( $puntosObtenidos->total > 0) 
								{{ number_format($puntosObtenidos->total, 2, '.', ',') }} puntos
							@else
								Sin puntos
							@endif
						</div>	
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
								@if ( $reporteComprobacion->count() > 0 )
									<i class="fa fa-flag lfu-fa-icon" aria-hidden="true"></i> 
									<span style="font-style:italic;">Tú has reportado a este usuario</span>
								@else
									<div class="perfil-opcion-usuario">
										<i class="fa fa-flag lfu-fa-icon" aria-hidden="true"></i> 
										<a id="lfu-reportar-usuario" style="cursor:pointer">Reportar usuario</a>
									</div>
								@endif
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
				    		<hr class="lfu-separador" style="border-color:transparent;">
				    		
				    		<?php $fecha = null;?>
				    		{{-- Se imprime el listado de las canciones, agrupándolas por fecha en la cual el usuario proveyó la letra --}}
					    	@foreach ( $letrasProvistas as $letraProvista )
					    		@if ( $fecha === null )
					    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			@include('includes.imprimir_listado_letras_provistas')
					    		@else
					    			@if ( $fecha === date('d/m/Y', strtotime($letraProvista->fecha_letra)) )
					    				<hr class="lfu-separador-cancion-misma-fecha">
					    				@include('includes.imprimir_listado_letras_provistas')
					    			@else
					    				<hr class="lfu-separador"  style="border-color:transparent;">
					    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
						    			<hr class="lfu-separador" style="border-top: 0px;">
					    				@include('includes.imprimir_listado_letras_provistas')
					    			@endif
					    		@endif
					            <?php $fecha = date('d/m/Y', strtotime($letraProvista->fecha_letra)); ?>
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
									<span style="font-style:italic;font-size:12px;"> (El {{ date('d/m/Y', strtotime($comentario->fecha)) }} a las {{ substr($comentario->fecha, 11, 8)  }})</span>
									<p id="lfu-comentario-descripcion">{{ $comentario->descripcion }}</p>
								</div>

								<hr class="lfu-separador-comentarios">
							@endforeach
							<i class="fa fa-circle-o lfu-fa-icon" aria-hidden="true"></i>
						@else
							<div id="lfu-sin-comentarios">
								<p>No hay comentarios</p>
								<hr class="lfu-separador-comentarios">
							</div>
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

	<div id="lfu-cargando" style="display:none;color:rgba(92, 180, 238, 1);margin-bottom:15px;"></div>

@endsection

@section('codigo-jquery-ajax')
	@if ( $usuario && $usuarioPerfil )
	<script>
		
		// INICIO de Código jQuery AJAX para Enviar Comentario en Perfil de Usuario
		$("#enviar-comentario").click(function() {

		    if ($('#lfu-textarea-comentario').val().trim() === '') {
		        $('#div-lfu-textarea-comentario').addClass('has-error');
		        $('#mensaje-error-comentario').fadeIn();
		    } else {
		    	$('#div-lfu-textarea-comentario').removeClass('has-error');
		        $('#mensaje-error-comentario').hide();
		       	var id_usuario = {{ $usuarioPerfil->id }};
	            var comment = $('#lfu-textarea-comentario').val();
	            var form = $('#formulario-comentar-perfil');
	            var url = form.attr('action').replace(':USER_ID', id_usuario);
	            var data = form.serialize();

	            var cargando = $("#lfu-cargando-envio-comentario");

				$(document).ajaxStart(function() {
					cargando.show();
				});

				$(document).ajaxStop(function() {
					cargando.hide();
				});

	            $.post(url, data, function(result) {
	            	if ( result['insertado'] === true) {
						$("#comentarModal").modal('hide'); // Se oculta el modal
		            	$("#lfu-textarea-comentario").val('');

		            	var descripcionComentario = result['comentarioUsuario'].descripcion;
		            	var fechaComentario = ((result['comentarioUsuario'].fecha.date).split(' ')[0]).match(/([^T]+)/)[0].split("-").reverse().join("/");
		            	var horaComentario = ((result['comentarioUsuario'].fecha.date).split(' ')[1]).substring(0,8);;

		            	console.log("Nuevo Comentario: "+descripcionComentario);
		         		console.log("Fecha: "+fechaComentario);
		         		console.log("Hora: "+horaComentario);

		            	var nuevoComentario = 
	        				'<div class="media-left lfu-container-avatar-comentario">'+
								'<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $usuario->nickname]) }}">'+
								'@if (Storage::disk('avatars')->has($usuario->imagen))'+
							        '<img src="{{ route('usuario.avatar', ['imagenNombre' => 'thumbnail_'.$usuario->imagen]) }}" alt="{{ $usuario->nickname }}"class="img-circle media-object lfu-comentario-avatar">'+
								'@else'+
									'<img src="{{ asset('images\lfu-default-avatar.png') }}" alt="{{ $usuario->nickname }}" class="img-circle media-object lfu-comentario-avatar" >'+
								'@endif'+
								'</a>'+
							'</div>'+
							'<div class="media-body lfu-comentario-individual">'+
								'<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $usuario->nickname]) }}">'+
									'<strong class="media-heading lfu-comentario-autor">{{$usuario->nickname}}</strong>'+
								'</a>'+
								'<strong> (Tú)</strong>'+
								'<span style="font-style:italic;font-size:12px;"> (El '+fechaComentario+' a las '+horaComentario+')</span>'+
								'<p id="lfu-comentario-descripcion">'+descripcionComentario+'</p>'+
							'</div>'+
							'<hr class="lfu-separador-comentarios">';
						$('#lfu-sin-comentarios').hide( "slow" );
		            	$('#lfu-comentarios').prepend(nuevoComentario);

		            	toastr.success('Tu comentario ha sido publicado.');
	            	} else {
	            		toastr.error('Error: Tu comentario no pudo ser publicado.');
	            	}
	            })
				.fail(function(jqXHR, textStatus, errorThrown) {
				    toastr.error('Error: Tu comentario no pudo ser publicado.');
				});
		    }
	    });
		// FIN de Código jQuery AJAX para Enviar Comentario en Perfil de Usuario

		// INICIO de Código jQuery AJAX para Enviar Mensaje Privado desde Perfil de Usuario
		$("#enviar-mensaje-desde-perfil").click(function() {

			var error = false;

		    if ($('#lfu-asunto-mensaje').val().trim() === '') {
		        $('#div-lfu-asunto-mensaje').addClass('has-error');
		        $('#mensaje-error-asunto').fadeIn();
		        error = true;
		    } else {
		    	$('#div-lfu-asunto-mensaje').removeClass('has-error');
		        $('#mensaje-error-asunto').hide();
		    } 

		    if ($('#lfu-textarea-mensaje').val().trim() === '') {
		        $('#div-lfu-textarea-mensaje').addClass('has-error');
		        $('#mensaje-error-textarea').fadeIn();
		        error = true;
		    } else {
		    	$('#div-lfu-textarea-mensaje').removeClass('has-error');
		        $('#mensaje-error-textarea').hide();
		    } 

		    if ( error === false ) {
		    	$('#div-lfu-asunto-mensaje').removeClass('has-error');
		    	$('#div-lfu-textarea-mensaje').removeClass('has-error');
		        $('#mensaje-error-asunto').hide();
		        $('#mensaje-error-textarea').hide();

	            var form = $('#formulario-enviar-mensaje-desde-perfil');
	            var url = form.attr('action');
	            var data = form.serialize();

				var cargando = $("#lfu-cargando-envio-mensaje");

				$(document).ajaxStart(function() {
					cargando.show();
				});

				$(document).ajaxStop(function() {
					cargando.hide();
				});

	            $.post(url, data, function(result) {
	            	if ( result['enviado'] === true) {
						$("#enviarMensajeDesdePerfilModal").modal('hide'); // Se oculta el modal
		            	$("#lfu-asunto-mensaje").val('');
		            	$("#lfu-textarea-mensaje").val('');

		            	var idMensajePrivado = result['mensajePrivado'].id;

		            	console.log("ID del mensaje privado enviado: "+idMensajePrivado);

		         		var mensajeConLink = 'El <a href="{{ route('ver_mensaje_enviado', ['id_mensaje' => ':MENSAJE_ID']) }}">mensaje privado</b></a> ha sido enviado satisfactoriamente.';

		         		var mensajeConLinkFinal = mensajeConLink.replace(':MENSAJE_ID', idMensajePrivado);
    					
    					toastr.success(mensajeConLinkFinal);
	            	} else {
	            		toastr.error('Error: El mensaje privado no pudo ser enviado.');
	            	}
	            })
				.fail(function(jqXHR, textStatus, errorThrown) {
				    toastr.error('Error: El mensaje privado no pudo ser enviado.');
				});

		    }
	    });

		$('#lfu-asunto-mensaje').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                // Para que se active el SUBMIT al presionar ENTER en el campo de texto del Asunto.
                return false;
            }
        });
		// FIN de Código jQuery AJAX para Enviar Mensaje Privado desde Perfil de Usuario

	</script>
	@endif
@endsection

