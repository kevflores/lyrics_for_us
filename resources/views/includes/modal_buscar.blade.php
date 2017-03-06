<!-- Modal para realizar una búsqueda -->
<div class="modal fade" id="buscarModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_busqueda" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-search"></span> Búsqueda</h4>
			</div>
			<div class="modal-body" style="text-align:center;">
				<form action="{{ route('resultados') }}" method="post" id="formRealizarBusqueda">
            		{!! csrf_field() !!}
            		<div class="form-group col-xs-12 col-sm-6 {{ $errors->has('tipo_busqueda') ? 'has-error' : '' }}">
						{!! Form::label('tipo_busqueda','Buscar', array('class'=>'label-izquierda', )) !!}
						{!! Form::select('tipo_busqueda', 
							[1 => 'Canción',
							 2 => 'Artista',
						     3 => 'Disco',
						     0 => 'Todo'],
						    old('tipo_busqueda'), ['class'=>'form-control']); !!}
					</div>
            		<div class="form-group col-xs-12 col-sm-6 {{ $errors->has('palabra_clave') ? 'has-error' : '' }}">
						{!! Form::label('palabra_clave','Palabra Clave', array('class'=>'label-izquierda', )) !!}
						{!! Form::text('palabra_clave', old('palabra_clave'), ['class'=>'form-control', 'style' => 'text-align:left;', 'id' => 'lfu-palabra-clave']) !!}
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-busqueda" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="realizar-busqueda" >Buscar</button>
				</form>
			</div>
		</div>
	</div>
</div> 