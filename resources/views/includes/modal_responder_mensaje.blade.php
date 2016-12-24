<!-- Modal para escribir y enviar mensaje a usuario -->
<div class="modal fade" id="responderMensajeModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_envio_mensaje" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Responder </h4>
			</div>
			<div class="modal-body" >

				<form action="{{ route('responder_mensaje') }}" method="post" id="form-responder-mensaje">
            		{!! csrf_field() !!}
            		<div class="form-group col-xs-12 {{ $errors->has('nickname') ? 'has-error' : '' }}">
						{!! Form::label('destinatario','Destinatario', array('class'=>'label-izquierda', )) !!}
						{!! Form::text('nickname', old('nickname'), ['class'=>'form-control','style' => 'text-align:left;', 'id' => 'lfu-nickname-mensaje', 'placeholder' => 'Ingrese nickname del usuario...', 'readonly' => 'true']) !!}
					</div>
            		<div class="form-group col-xs-12 {{ $errors->has('asunto') ? 'has-error' : '' }}">
						{!! Form::label('asunto','Asunto', array('class'=>'label-izquierda', )) !!}
						{!! Form::text('asunto', old('asunto'), ['class'=>'form-control','style' => 'text-align:left;', 'id' => 'lfu-asunto-mensaje']) !!}
					</div>
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-mensaje') ? 'has-error' : '' }}">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-mensaje" name="descripcion-mensaje" placeholder="Ingresar mensaje..." style="resize: none;">{{ old('descripcion-mensaje') }}</textarea>
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-envio-mensaje" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="enviar-mensaje-respuesta" >Enviar mensaje</button>
				</form>

			</div>
		</div>
	</div>
</div> 