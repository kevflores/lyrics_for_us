<!-- Modal para confirmar la eliminación de mensaje del usuario -->
<div class="modal fade" id="eliminarMensajeRecibidoModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close cerrar_modal estilo-cerrar-modal" data-dismiss="modal">&times;</button>
				<h4><span id="preguntaMensaje"></span></h4>
			</div>
			<div class="modal-body" >
				<form action="{{ route('borrar_mensaje_recibido_leido') }}" method="post" id="formEliminarMensaje">
					 {!! csrf_field() !!}
					<input type="hidden" name="id_mensaje">
					<button type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="confirmarEliminacionMensaje" >Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div> 