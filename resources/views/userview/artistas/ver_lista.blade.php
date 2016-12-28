@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-default">
			<div class="panel-heading" id="lfu-panel-heading-default">Artistas</div>
			<div class="panel-body" id="lfu-panel-body-default">
				<div class="" id="lfu-artistas-opciones">
					@include('includes.opciones_artistas')
				</div>
				<hr class="lfu-separador">
				<div class="" id="lfu-artistas-listado" style="margin: auto 0;text-align:center;">
					@if ( is_obj_empty($artistas) )
						@foreach ($artistas as $artista)
							{{ $artista->nombre }}
							<br>
						@endforeach
					@else
						No hay artistas.
					@endif
				</div> 
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary lfu-panel-footer-default">
			<div class="panel-primary panel-footer sin-texto lfu-panel-footer-default"></div>
		</div>
	</div>
    
@endsection