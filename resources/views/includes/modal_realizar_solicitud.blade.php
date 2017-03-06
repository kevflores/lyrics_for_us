<!-- Modal para realizar y enviar una solicitud -->
<div class="modal fade" id="realizarSolicitudModal" role="dialog">
	<div class="modal-dialog">
	<!-- Contenido del Modal-->
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close estilo-cerrar-modal cerrar_modal_realizar_solicitud" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-pencil"></span> Realizar nueva solicitud </h4>
			</div>
			<div class="modal-body" >

				<form action="{{ route('usuario.enviar_solicitud') }}" method="post" id="formRealizarSolicitud">
            		{!! csrf_field() !!}
            		<div class="form-group col-xs-12 {{ $errors->has('tipo_solicitud') ? 'has-error' : '' }}">
						{!! Form::label('tipo_solicitud','Tipo de solicitud', array('class'=>'label-izquierda', )) !!}
						{!! Form::select('tipo_solicitud', $tiposSolicitudes, old('tipo_solicitud'), ['class'=>'form-control']); !!}
					</div>
            		<div class="form-group col-xs-12 {{ $errors->has('titulo') ? 'has-error' : '' }}">
						{!! Form::label('titulo','Título', array('class'=>'label-izquierda', )) !!}
						{!! Form::text('titulo', old('titulo'), ['class'=>'form-control', 'style' => 'text-align:left;', 'id' => 'lfu-titulo-solicitud']) !!}
					</div>
            		<div class="form-group col-xs-12 {{ $errors->has('descripcion') ? 'has-error' : '' }}">
						{!! Form::label('descripcion','Descripción', array('class'=>'label-izquierda', )) !!}
						{!! Form::textarea('descripcion', old('descripcion'), ['class' => 'form-control','style' => 'text-align:left;height:75px;resize:none;', 'id' => 'lfu-descripcion-solicitud']) !!}
					</div>
					<button type="button" class="btn btn-danger" id="cancelar-solicitud" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="enviar-solicitud" >Enviar</button>
				</form>

			</div>
		</div>
	</div>
</div> 