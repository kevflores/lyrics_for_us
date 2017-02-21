<!-- Modal para crear comentario en la sección individual por Canción -->
<div class="modal fade" id="comentarModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close cerrar_modal" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span>
					Comentar sobre {{ $artista->nombre }}
				</h4>
			</div>
			<div class="modal-body" >
				<form action="{{ route('artistas.comentar', ['id_artista' => $artista->id]) }}" method="post">
					{!! csrf_field() !!}
					<div class="form-group col-xs-12 {{ $errors->has('descripcion-comentario') ? 'has-error' : '' }}">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-comentario" name="descripcion-comentario" placeholder="Ingresar comentario..." style="resize: none;" autofocus>{{ old('descripcion-comentario') }}</textarea>
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-comentario" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="enviar-comentario" >Enviar</button>
				</form>
			</div>
		</div>
	</div>
</div> 