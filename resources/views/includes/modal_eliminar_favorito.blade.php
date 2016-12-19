<!-- Modal para confirmar la eliminación de un favorito del usuario -->
<div class="modal fade" id="eliminarFavoritoModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close cerrar_modal estilo-cerrar-modal" data-dismiss="modal">&times;</button>
				<h4><span id="preguntaFavorito"></span></h4>
			</div>
			<div class="modal-body" >
				<form action="{{ route('eliminar_favorito') }}" method="post" id="formEliminarFavorito">
					 {!! csrf_field() !!}
					<input type="hidden" name="tipo">
					<input type="hidden" name="id_favorito">
					<button type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="confirmarEliminacionFavorito" >Eliminar</button>
				</form>
				
			</div>
		</div>
	</div>
</div> 