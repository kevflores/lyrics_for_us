<!-- Modal para enviar mensaje a usuario desde su perfil -->
<div class="modal fade" id="reportarUsuarioModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_reporte_usuario" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Reportar a usuario: {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }}</h4>
			</div>
			<div class="modal-body" >
				<form action="{{ route('usuario.reportar', ['id_usuario' => $usuarioPerfil->id]) }}" method="post">
            		{!! csrf_field() !!}
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-reporte') ? 'has-error' : '' }}">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-reporte-usuario" name="descripcion-reporte" placeholder="Ingresar reporte..." style="resize: none;" autofocus>{{ old('descripcion-reporte') }}</textarea>
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-envio-reporte-usuario" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="enviar-reporte-usuario-perfil" >Enviar mensaje</button>
				</form>
			</div>
		</div>
	</div>
</div> 