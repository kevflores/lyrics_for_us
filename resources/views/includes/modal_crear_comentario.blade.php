<!-- Modal para crear comentario en el perfil del usuario -->
<div class="modal fade" id="comentarModal" role="dialog">
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