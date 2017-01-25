@extends('layouts.master_usuario')

@section('titulo')
    Solicitud: "{{ $solicitud->titulo }}" | Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-solicitudes" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
			<div class="panel-heading" id="lfu-panel-heading-solicitudes">Solicitud: <span style="font-style:italic;">"{{ $solicitud->titulo }}"</span></div>
			<div class="panel-body" id="lfu-solicitud">
				<strong>Tipo: </strong><span class="info-solicitud">{{ $solicitud->tipo()->first()->descripcion }}</span>
				<br>
				<strong>Título: </strong><span class="info-solicitud">"{{ $solicitud->titulo }}"</span>
				<br> 
				<strong>Fecha: </strong><span class="info-solicitud">{{ date('d/m/Y', strtotime($solicitud->fecha_solicitud)) }} a las {{  date('h:i A', strtotime($solicitud->fecha_solicitud)) }}</span>
				<br>

				<hr class="lfu-separador">
				<strong>Descripción: </strong><span class="info-solicitud">{{ $solicitud->descripcion }}</span>
				<hr class="lfu-separador">
				<strong>Estado: </strong>
					<span class="info-solicitud">
						@if ( $solicitud->estado === null )
							<i class="fa fa-clock-o" aria-hidden="true" style="cursor:default;"></i> Solicitud en espera
						@elseif ( $solicitud->estado === true )
							<i class="fa fa-check-circle" aria-hidden="true" style="cursor:default;color:#2A8A3A;"></i> Solicitud aceptada
						@else ( $solicitud->estado === false )
							<i class="fa fa-times-circle" aria-hidden="true" style="cursor:default;color:#BE1E1E;"></i> Solicitud rechazada
						@endif
					</span>
				<br>
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary panel-footer-configuracion">
			<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
		</div>
	</div>

	<div class="col-xs-12" style="margin-top:5px;">
		<a class="btn btn-primary" href="{{ URL::previous() }}">Volver</a>
    </div>
    
@endsection