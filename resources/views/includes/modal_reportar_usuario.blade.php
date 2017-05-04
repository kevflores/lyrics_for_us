<!-- Modal para reportar a usuario -->
<div class="modal fade" id="reportarUsuarioModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_reporte_usuario" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Reportar a usuario: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}</h4>
			</div>
			<div class="modal-body" >

				{!! Form::open(['route' => ['usuario.reportar', 'id_usuario' => ':USER_ID'], 'method' => 'POST', 'id' => 'formulario-reportar-usuario']) !!}

					{!! csrf_field() !!}
					
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-reporte') ? 'has-error' : '' }}" id="div-lfu-textarea-reporte">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-reporte-usuario" name="descripcion-reporte" placeholder="Ingresar reporte..." style="resize: none;" autofocus>{{ old('descripcion-reporte') }}</textarea>
						<div id="mensaje-error-reporte-usuario" style="display:none;margin-top:15px;">
							<span style="color:#880E0E;text-size:12px;">Debes escribir la razón por la cual estás reportando al usuario.</span>
						</div>
					</div>
					
					<div id="lfu-cargando-envio-reporte-usuario" style="display:none;color:rgba(92, 180, 238, 1);margin-bottom:15px;">
						Enviando Reporte...
					</div>
					
					<button type="button" class="btn btn-danger" id="cancelar-envio-reporte-usuario" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" id="enviar-reporte-usuario-perfil" >Enviar reporte</button>

				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div> 


