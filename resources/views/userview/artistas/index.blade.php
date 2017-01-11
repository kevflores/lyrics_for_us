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
				@if ( is_obj_empty($artistas) )
					
					<?php $cantidad = 0; ?>
					@foreach ($artistas as $artista)
						<?php $cantidad++; ?>
					@endforeach

					@if ( $cantidad === 1 )
						<div style="margin: auto 0;text-align:center;">
							@foreach ($artistas as $artista)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
									<div class="well well-sm well-artista-nombre">
										{{ $artista->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@elseif ( $cantidad === 2 || $cantidad === 4 )
						<div id="lfu-artistas-listado-dos" style="margin: auto 0;text-align:center;">
							@foreach ($artistas as $artista)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
									<div class="well well-sm well-artista-nombre">
										{{ $artista->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@else
						<div id="lfu-artistas-listado" style="margin: auto 0;text-align:center;">
							@foreach ($artistas as $artista)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
									<div class="well well-sm well-artista-nombre">
										{{ $artista->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@endif
				@else
					<div class="well well-sm" style="margin: auto 0;text-align:center;">
						No hay artistas <span style="font-style:italic;color:red;">(Mostrar imagen)</span>.
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