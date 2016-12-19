@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

<div class="btn-group lfu-botones-mensajes" style="margin-bottom:25px;">
    <a href="{{ route('mensajes_recibidos') }}" class="btn btn-primary active"><strong>Mensajes recibidos</strong></a>
    <a href="{{ route('mensajes_enviados') }}" class="btn btn-primary">Mensajes enviados</a>
</div>

@include('includes.bloque_de_mensajes')
    
    @if ( is_obj_empty($mensajes) )

    	@include('includes.modal_eliminar_mensaje')

        <form action="" id="formulario-mensajes-recibidos" method="post">
			{!! csrf_field() !!}

			<div class="col-xs-4" style="text-align:left;padding:0px;">
				<button type="submit" class="btn btn-primary" id="escribir-mensaje" style="margin-bottom:5px;">Escribir mensaje</button>
			</div>
			<div class="col-xs-8" style="text-align:right;padding:0px;">
				<button type="submit" class="btn btn-primary" id="marcar-como-leidos" style="margin-bottom:5px;">Marcar como leídos</button>
				<button type="submit" class="btn btn-primary" id="borrar-marcados" style="margin-bottom:5px;">Eliminar mensajes marcados</button>
			</div>

			<table class="table table-bordered" id="lfu-tabla-mensajes" style="">
				<thead style="">
					<tr>
						<th><input type="checkbox" onclick="marcar(this);" /></th>
						<th>Asunto</th>
						<th>Remitente</th>
						<th>Fecha y hora</th>
						<th><i class="fa fa-trash" aria-hidden="true"></i></th>
					</tr>
				</thead>
				<tbody id="lfu-tabla-body">
					@foreach ($mensajes as $mensajeRecibido)
						<tr style="{{ $mensajeRecibido->visto === false ? 'font-weight:bold;' : '' }}" >
							<td style="width:2%;" align="center"><input class="casilla_marcar" name ="chk[]" id="chk<?php $mensajeRecibido->id; ?>" type="checkbox" 
							<?php
							if (isset($this->seleccion[$mensajeRecibido->id])) {
							echo 'checked';
							}
							?> value="<?php echo $mensajeRecibido->id ?>" /></td>
							<td style="width:56%;">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('ver_mensaje_enviado', ['id_mensaje' => $mensajeRecibido->id]) }}">
									{{ $mensajeRecibido->asunto }}
								</a>
							</td>
							<td style="width:15%;">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $mensajeRecibido->usuarioEmisor()->first()->nickname]) }}">
									{{ $mensajeRecibido->usuarioEmisor()->first()->nickname }}
								</a>
							</td>
							<td style="width:25%;">{{ date('d/m/Y', strtotime($mensajeRecibido->fecha)) }} a las {{  date('h:i A', strtotime($mensajeRecibido->fecha)) }}</td>
							<td style="width:2%;"  data-idmensaje="{{ $mensajeRecibido->id }}" data-asunto="{{ $mensajeRecibido->asunto }}"> 
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
		No hay mensajes (vista de prueba).
	@endif

<script>
	function marcar(source) {
		checkboxes=document.getElementsByClassName('casilla_marcar');
		for(i=0;i<checkboxes.length;i++) { 
			if(checkboxes[i].type == "checkbox") { 
				checkboxes[i].checked=source.checked;
			}
		}
	}

	var urlMarcarComoLeidos = '{{ route('marcar_como_leidos') }}';
	var urlBorrarMacados = '{{ route('borrar_mensajes_recibidos') }}';
</script>

@endsection