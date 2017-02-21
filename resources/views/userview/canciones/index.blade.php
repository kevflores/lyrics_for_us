@extends('layouts.master_usuario')

@section('titulo')
    Canciones | Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-default">
			<div class="panel-heading" id="lfu-panel-heading-default">Canciones</div>
			<div class="panel-body" id="lfu-panel-body-default">
				<div>
					@include('includes.opciones_canciones')
				</div>
				<hr class="lfu-separador">
				@if ( count($canciones) )
					
					<?php $cantidad = 0; ?>
					@foreach ($canciones  as $cancion)
						<?php $cantidad++; ?>
					@endforeach

					@if ( $cantidad === 1 )
						<div style="margin: auto 0;text-align:center;">
							@foreach ($canciones as $cancion)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
									<div class="well well-sm well-cancion-nombre">
										<strong>"{{ $cancion->titulo }}"</strong>
										@include('includes.imprimir_artistas_principales');
									</div>
								</a>
							@endforeach
						</div> 
					@elseif ( $cantidad === 2 || $cantidad === 4 )
						<div id="lfu-discos-listado-dos" style="margin: auto 0;text-align:center;">
							@foreach ($canciones as $cancion)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
									<div class="well well-sm well-cancion-nombre">
										<strong>"{{ $cancion->titulo }}"</strong>
										@include('includes.imprimir_artistas_principales');
									</div>
								</a>
							@endforeach
						</div> 
					@else
						<div id="lfu-discos-listado" style="margin: auto 0;text-align:center;">
							@foreach ($canciones as $cancion)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
									<div class="well well-sm well-cancion-nombre">
										<strong>"{{ $cancion->titulo }}"</strong>
										@include('includes.imprimir_artistas_principales');
									</div>
								</a>
							@endforeach
						</div> 
					@endif
				@else
					<div class="well well-sm" style="margin: auto 0;text-align:center;">
						No hay canciones <span style="font-style:italic;color:red;">(Mostrar imagen)</span>.
					</div> 
				@endif
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary lfu-panel-footer-default">
			<div class="panel-primary panel-footer sin-texto lfu-panel-footer-default"></div>
		</div>
	</div>
    
@endsection