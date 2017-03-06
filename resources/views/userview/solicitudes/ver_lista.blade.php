@extends('layouts.master_usuario')

@section('titulo')
    Mis Solicitudes | Lyrics For Us
@endsection

@section('contenido')
    
    @include('includes.bloque_de_mensajes')
    @include('includes.modal_realizar_solicitud')

    @if ( is_obj_empty($solicitudes) )

	    <div style="text-align:right;padding:0px;">
			<a class="btn btn-primary" id="lfu-realizar-solicitud" style="margin-bottom:5px;">Realizar nueva solicitud</a>
		</div>

		<div>
			<div class="panel panel-primary" id="lfu-panel-solicitudes" style="">
				<div class="panel-heading" id="lfu-panel-heading-solicitudes">Mis Solicitudes</div>	    	
			</div>
		</div>
		

		<table class="table table-bordered" id="lfu-tabla" style="">
			<thead style="">
				<tr>
					<th style="font-weight:normal;">Tipo</th>
					<th style="font-weight:normal;">Título</th>
					<th style="font-weight:normal;">Fecha y hora</th>
					<th style="font-weight:normal;">Estado</th>
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
							@if ( $solicitud->estado === null )
								<i class="fa fa-clock-o" aria-hidden="true" title="Solicitud en espera" style="cursor:default;"></i>
							@elseif ( $solicitud->estado === true )
								<i class="fa fa-check-circle" aria-hidden="true" title="Solicitud aceptada" style="cursor:default;color:#2A8A3A;"></i>
							@else ( $solicitud->estado === false )
								<i class="fa fa-times-circle" aria-hidden="true" title="Solicitud rechazada" style="cursor:default;color:#BE1E1E;"></i>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	@else
		<div>
			<div class="panel panel-primary" id="lfu-panel-solicitudes" style="">
				<div class="panel-heading" id="lfu-panel-heading-solicitudes">Mis Solicitudes</div>	    	
			</div>
		</div>
		<div class="jumbotron info jumbo-" id="lfu-jumbotron" style="margin:auto;">
        	Aún no ha realizado solicitudes.
        	<a id="lfu-realizar-solicitud" style="display:block;margin-top:20px;cursor:pointer;">Presione aquí para realizar una solicitud</a>
        </div>
	@endif

	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary panel-footer-solicitudes">
			<div class="panel-primary panel-footer sin-texto panel-footer-solicitudes" id="lfu-panel-footer"></div>
		</div>
	</div>

	{{ $solicitudes->links() }}

@endsection