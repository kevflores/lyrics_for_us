@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-solicitudes" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
			<div class="panel-heading" id="lfu-panel-heading-solicitudes">Mis Solicitudes</div>
			<div class="panel-body" id="lfu-solicitud">
				<hr class="lfu-separador">
				{{ $solicitud->descripcion }}
				<hr class="lfu-separador">
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