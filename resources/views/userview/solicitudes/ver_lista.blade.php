@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
    @include('includes.bloque_de_mensajes')
    @include('includes.modal_realizar_solicitud')
	<h3>Mis Solicitudes</h3>
   <div class="col-xs-12" style="text-align:left;padding:0px;">
		<a class="btn btn-primary" id="lfu-realizar-solicitud" style="margin-bottom:5px;">Realizar nueva solicitud</a>
	</div>

	<table class="table table-bordered" id="lfu-tabla-mensajes" style="">
	<thead style="">
		<tr>
			<th>Tipo</th>
			<th>Título</th>
			<th>Fecha y hora</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody id="lfu-tabla-body">
		@foreach ($solicitudes as $solicitud)
			<tr>
				<td style="width:;">
					{{ $solicitud->tipo()->first()->descripcion }}
				</td>
				<td style="width:;">
					<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.ver_solicitud', ['id_solicitud' => $solicitud->id]) }}">
						{{ $solicitud->titulo }}
					</a>
				</td>
				<td style="width:;">{{ date('d/m/Y', strtotime($solicitud->fecha_solicitud)) }} a las {{  date('h:i A', strtotime($solicitud->fecha_solicitud)) }}
				</td>
				<td>
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

{{ $solicitudes->links() }}

@endsection