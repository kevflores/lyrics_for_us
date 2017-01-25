@extends('layouts.master_usuario')

@section('titulo')
    Mensajes Enviados | Lyrics For Us
@endsection

@section('contenido')
    
<div class="btn-group lfu-botones-mensajes" style="margin-bottom:25px;">
    <a href="{{ route('mensajes_recibidos') }}" class="btn btn-primary">Mensajes recibidos</a>
    <a href="{{ route('mensajes_enviados') }}" class="btn btn-primary active"><strong>Mensajes enviados</strong></a>
</div>

@include('includes.bloque_de_mensajes')
@include('includes.modal_escribir_mensaje')
    
    @if ( is_obj_empty($mensajes) )

    	@include('includes.modal_eliminar_mensaje_enviado')

        <form action="" id="formulario-mensajes-enviados" method="post">
			{!! csrf_field() !!}

			<div class="col-xs-4" style="text-align:left;padding:0px;">
				<a class="btn btn-primary" id="lfu-escribir-mensaje" style="margin-bottom:5px;">Escribir mensaje</a>
			</div>
			<div class="col-xs-8" style="text-align:right;padding:0px;">
				<button type="submit" class="btn btn-primary" id="borrar-enviados-marcados" style="margin-bottom:5px;">Eliminar mensajes marcados</button>
			</div>

			<table class="table table-bordered" id="lfu-tabla" style="">
				<thead style="">
					<tr>
						<th><input type="checkbox" onclick="marcar(this);" /></th>
						<th>Asunto</th>
						<th>Destinatario</th>
						<th>Fecha y hora</th>
						<th><i class="fa fa-trash" aria-hidden="true"></i></th>
					</tr>
				</thead>
				<tbody id="lfu-tabla-body">
					@foreach ($mensajes as $mensajeEnviado)
						<tr >
							<td style="width:2%;" align="center"><input class="casilla_marcar" name ="chk[]" id="chk<?php $mensajeEnviado->id; ?>" type="checkbox" 
							<?php
							if (isset($this->seleccion[$mensajeEnviado->id])) {
							echo 'checked';
							}
							?> value="<?php echo $mensajeEnviado->id ?>" /></td>
							<td style="width:56%;">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('ver_mensaje_enviado', ['id_mensaje' => $mensajeEnviado->id]) }}">
									{{ $mensajeEnviado->asunto }}
								</a>
							</td>
							<td style="width:15%;">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $mensajeEnviado->usuarioReceptor()->first()->nickname]) }}">
									{{ $mensajeEnviado->usuarioReceptor()->first()->nickname }}
								</a>
								<?php
									if ( $mensajeEnviado->usuarioReceptor()->first()->nickname === $usuario->nickname ) {
										echo "(Tú)";
									} 
								?>
							</td>
							<td style="width:25%;">{{ date('d/m/Y', strtotime($mensajeEnviado->fecha)) }} a las {{  date('h:i A', strtotime($mensajeEnviado->fecha)) }}</td>
							<td style="width:2%;"  data-idmensaje="{{ $mensajeEnviado->id }}" data-asunto="{{ $mensajeEnviado->asunto }}"> 
								<a class="eliminar-mensaje" style="cursor: pointer;">
								<i class="fa fa-times" aria-hidden="true" title="Eliminar mensaje"></i>
								</a> 
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="lfu-seccion-completa col-xs-12">
		    	<div class="panel panel-primary panel-footer-configuracion">
					<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
				</div>
			</div>

			
			<input type="hidden" name="_token" value="{{ Session::token() }}">

		</form>



	@else
			
		<div class="col-xs-12 jumbotron info" style="margin:auto;">
        	No hay mensajes.
        	<a id="lfu-escribir-mensaje" style="display:block;margin-top:20px;cursor:pointer;">Presione aquí para escribir un mensaje</a>
        </div>
	@endif
	
	<div class="col-xs-12"> 
		{{ $mensajes->links() }}
	</div>

<script>
	function marcar(source) {
		checkboxes=document.getElementsByClassName('casilla_marcar');
		for(i=0;i<checkboxes.length;i++) { 
			if(checkboxes[i].type == "checkbox") { 
				checkboxes[i].checked=source.checked;
			}
		}
	}

	var urlBorrarMacados = '{{ route('borrar_mensajes_enviados') }}';
</script>

@endsection