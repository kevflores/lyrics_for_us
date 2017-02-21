@extends('layouts.master_usuario')

@section('titulo')
    Discos
    @if ( $seleccion !== 'top' )
    	(Letra {{ strtoupper($seleccion) }})
    @endif
     | Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-default">
			<div class="panel-heading" id="lfu-panel-heading-default">Discos</div>
			<div class="panel-body" id="lfu-panel-body-default">
				<div>
					@include('includes.opciones_discos')
				</div>
				<hr class="lfu-separador">
				@if ( count($discos) )
					
					<?php $cantidad = 0; ?>
					@foreach ($discos  as $disco)
						<?php $cantidad++; ?>
					@endforeach

					@if ( $cantidad === 1 )
						<div style="margin: auto 0;text-align:center;">
							@foreach ($discos as $disco)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}">
									<div class="well well-sm well-disco-nombre">
										<strong>"{{ $disco->titulo }}"</strong> de 
										{{ (App\Disco::find($disco->id)->artista)->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@elseif ( $cantidad === 2 || $cantidad === 4 )
						<div id="lfu-discos-listado-dos" style="margin: auto 0;text-align:center;">
							@foreach ($discos as $disco)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}">
									<div class="well well-sm well-disco-nombre">
										<strong>"{{ $disco->titulo }}"</strong> de 
										{{ (App\Disco::find($disco->id)->artista)->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@else
						<div id="lfu-discos-listado" style="margin: auto 0;text-align:center;">
							@foreach ($discos as $disco)
								<a class="lfu-enlace-sin-decoracion-well" href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}">
									<div class="well well-sm well-disco-nombre">
										<strong>"{{ $disco->titulo }}"</strong> de 
										{{ (App\Disco::find($disco->id)->artista)->nombre }}
									</div>
								</a>
							@endforeach
						</div> 
					@endif
				@else
					<div class="well well-sm" style="margin: auto 0;text-align:center;">
						No hay discos <span style="font-style:italic;color:red;">(Mostrar imagen)</span>.
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
    @if ( is_obj_empty($discos) )
		<div class="col-xs-12"> 
			{{ $discos->links() }}
		</div>
	@endif
    
@endsection