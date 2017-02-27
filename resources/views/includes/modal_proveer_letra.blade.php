<!-- Modal para proveer la letra de una canción -->
<div class="modal fade" id="proveerLetraModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_proveer_letra" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Escribir la letra de <strong>"{{ $cancion->titulo }}"</strong> </h4>
			</div>
			<div class="modal-body" >
				<form action="{{ route('canciones.guardar', ['id_cancion' => $cancion->id]) }}" method="post">
            		{!! csrf_field() !!}
					<div class="form-group col-xs-12 {{ $errors->has('letra-cancion') ? 'has-error' : '' }}">
						<textarea class="form-control" rows="8" cols="50" id="lfu-textarea-letra-cancion" name="letra-cancion" placeholder="Ingresar letra..." style="resize: none;" autofocus>{{ old('letra-cancion') }}</textarea>
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-guardado-letra" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="guardar-letra" >Registrar letra</button>
				</form>
			</div>
		</div>
	</div>
</div> 