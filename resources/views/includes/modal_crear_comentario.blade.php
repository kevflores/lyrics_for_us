<!-- Modal para crear comentario en el perfil del usuario -->
<div class="modal fade" id="comentarModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close cerrar_modal" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span>
				@if ( $usuarioPerfil->id !== Auth::User()->id )
					 Comentar en el perfil de {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}
				@else
					 Comentar en tu propio perfil
				@endif
				</h4>
			</div>
			<div class="modal-body" >
				
				{{--
				<form action="{{ route('usuario.comentar', ['id_usuario' => $usuarioPerfil->id]) }}" method="post">
					{!! csrf_field() !!}
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-comentario') ? 'has-error' : '' }}">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-comentario" name="descripcion-comentario" placeholder="Ingresar comentario..." style="resize: none;" autofocus>{{ old('descripcion-comentario') }}</textarea>
					</div>
					<div>
						<span id="msg">Aquí.</span>
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-comentario" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="enviar-comentario" >Enviar</button>
				</form>
				--}}

				{!! Form::open(['route' => ['usuario.comentar', ':USER_ID'], 'method' => 'POST', 'id' => 'formulario-comentar-perfil']) !!}

					{!! csrf_field() !!}
					
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-comentario') ? 'has-error' : '' }}" id="div-lfu-textarea-comentario">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-comentario" name="descripcion-comentario" placeholder="Ingresar comentario..." style="resize: none;" autofocus>{{ old('descripcion-comentario') }}</textarea>
						<div id="mensaje-error-comentario" style="display:none;margin-top:3px;">
							<span style="color:#880E0E;text-size:12px;">Debes comentar algo.</span>
						</div>
					</div>
					
					<div id="lfu-cargando" style="display:none;color:rgba(92, 180, 238, 1);margin-bottom:15px;">
						Enviando Comentario...
					</div>
					
					<button type="button" class="btn btn-danger" id="cancelar-comentario" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" id="enviar-comentario" >Enviar</button>

				{!! Form::close() !!}


			</div>
		</div>
	</div>
</div> 