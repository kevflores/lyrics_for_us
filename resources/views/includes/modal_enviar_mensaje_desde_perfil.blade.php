<!-- Modal para enviar mensaje a usuario desde su perfil -->
<div class="modal fade" id="enviarMensajeDesdePerfilModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Escribir mensaje privado para: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}</h4>
			</div>
			<div class="modal-body" >

				{!! Form::open(['route' => ['enviar_mensaje', 'id_receptor' => $usuarioPerfil->id, 'origen' => 'vista_de_perfil_de_usuario'], 'method' => 'POST', 'id' => 'formulario-enviar-mensaje-desde-perfil']) !!}

					{!! csrf_field() !!}
					
					<div class="form-group col-xs-12 {{ $errors->has('asunto') ? 'has-error' : '' }}" id="div-lfu-asunto-mensaje">
						{!! Form::label('asunto','Asunto', array('class'=>'label-izquierda')) !!}
						{!! Form::text('asunto', old('asunto'), ['class'=>'form-control','style' => 'text-align:left;', 'id' => 'lfu-asunto-mensaje']) !!}
						<div id="mensaje-error-asunto" style="display:none;margin-top:7px;">
							<span style="color:#880E0E;text-size:12px;">Debes ingresar el asunto del mensaje.</span>
						</div>
					</div>
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-mensaje') ? 'has-error' : '' }}" id="div-lfu-textarea-mensaje">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-mensaje" name="descripcion-mensaje" placeholder="Ingresar mensaje..." style="resize: none;">{{ old('descripcion-mensaje') }}</textarea>
						<div id="mensaje-error-textarea" style="display:none;margin-top:7px;">
							<span style="color:#880E0E;text-size:12px;">Debes ingresar el contenido del mensaje.</span>
						</div>
					</div>

					<div id="lfu-cargando-envio-mensaje" style="display:none;color:rgba(92, 180, 238, 1);margin-bottom:15px;">
						Enviando Mensaje Privado...
					</div>

					<button type="button" class="btn btn-danger" id="cancelar-envio-mensaje" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" id="enviar-mensaje-desde-perfil" >Enviar mensaje</button>

				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>