@extends('layouts.master_usuario')

@section('titulo')
  Resultados de Búsqueda | Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary" id="lfu-panel-solicitudes" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
			<div class="panel-heading" id="lfu-panel-heading-solicitudes">Búsqueda</div>
			<div class="panel-body" id="lfu-solicitud">
				<div class="col-md-8 col-md-offset-2">
					<form action="{{ route('resultados') }}" method="post">
			  		{!! csrf_field() !!}

			  		<div class="form-group col-xs-12 col-sm-6 {{ $errors->has('tipo_busqueda') ? 'has-error' : '' }}">
						{!! Form::label('tipo_busqueda','Buscar', array('class'=>'label-izquierda', )) !!}
						{!! Form::select('tipo_busqueda', 
							[0 => 'Todo',
							 1 => 'Artista',
						   2 => 'Disco',
						   3 => 'Canción'],
						   $tipo_busqueda, ['class'=>'form-control']); !!}
						</div>

			    	<div class="form-group col-xs-12 col-sm-6 {{ $errors->has('palabra_clave') ? 'has-error' : '' }}">
							{!! Form::label('palabra_clave','Palabras Clave', array('class'=>'label-izquierda', )) !!}
							{!! Form::text('palabra_clave', $palabra_clave, ['class'=>'form-control', 'style' => 'text-align:left;', 'id' => 'lfu-palabra-clave']) !!}
						</div>

						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary" id="realizar-busqueda" >Buscar</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
		<div class="panel panel-primary" id="lfu-panel-solicitudes" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;border-top:0px;">
			<div class="panel-heading" id="lfu-panel-heading-solicitudes" style="border-top-left-radius:0px;border-top-right-radius:0px;">Resultados</div>
			<div class="panel-body" id="lfu-solicitud">

				<div class="lfu-seccion-completa col-xs-12">
					@if ( $rTodos )
						@if ( $rTodos === true)
							@if ( ($rArtistas->count() + $rDiscos->count() + $rCanciones->count()) > 0 )
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								  @if ($rArtistas->count() > 0)
									  <div class="panel panel-primary">
									    <div class="panel-heading" role="tab" id="headingOne" style="background-color:rgba(92, 180, 238, 1);font-size:14px;">
									        <a class="lfu-enlace-sin-decoracion" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									          Ver Listado de Artistas
									        </a>
									    </div>
									    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">

													<?php $cantidad = 0; ?>
													@foreach ($rArtistas as $artista)
														<?php $cantidad++; ?>
													@endforeach

													@if ( $cantidad === 1 )
														<div style="margin: auto 0;text-align:center;">
															@foreach ($rArtistas as $artista)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
																	<div class="well well-sm well-artista-nombre">
																		{{ $artista->nombre }}
																	</div>
																</a>
															@endforeach
														</div> 
													@elseif ( $cantidad === 2 || $cantidad === 4 )
														<div id="lfu-artistas-listado-dos" style="margin: auto 0;text-align:center;">
															@foreach ($rArtistas as $artista)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
																	<div class="well well-sm well-artista-nombre">
																		{{ $artista->nombre }}
																	</div>
																</a>
															@endforeach
														</div> 
													@else
														<div id="lfu-artistas-listado" style="margin: auto 0;text-align:center;">
															@foreach ($rArtistas as $artista)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
																	<div class="well well-sm well-artista-nombre">
																		{{ $artista->nombre }}
																	</div>
																</a>
															@endforeach
														</div> 
													@endif

									      </div>
									    </div>
									  </div>
								  @endif
								  @if ($rDiscos->count() > 0)
									  <div class="panel panel-primary">
									    <div class="panel-heading" role="tab" id="headingTwo" style="background-color:rgba(92, 180, 238, 1);font-size:14px;">
									        <a class="lfu-enlace-sin-decoracion" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									          Ver Listado de Discos
									        </a>
									    </div>
									    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
									      <div class="panel-body">
									        
													<?php $cantidad = 0; ?>
													@foreach ($rDiscos  as $disco)
														<?php $cantidad++; ?>
													@endforeach

													@if ( $cantidad === 1 )
														<div style="margin: auto 0;text-align:center;">
															@foreach ($rDiscos as $disco)
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
															@foreach ($rDiscos as $disco)
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
															@foreach ($rDiscos as $disco)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}">
																	<div class="well well-sm well-disco-nombre">
																		<strong>"{{ $disco->titulo }}"</strong> de 
																		{{ (App\Disco::find($disco->id)->artista)->nombre }}
																	</div>
																</a>
															@endforeach
														</div> 
													@endif

									      </div>
									    </div>
									  </div>
								  @endif
								  @if ($rCanciones->count() > 0)
									  <div class="panel panel-primary">
									    <div class="panel-heading" role="tab" id="headingThree" style="background-color:rgba(92, 180, 238, 1);font-size:14px;">
									        <a class="lfu-enlace-sin-decoracion" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									          Ver Listado de Canciones
									        </a>
									    </div>
									    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
									      <div class="panel-body">

													<?php $cantidad = 0; ?>
													@foreach ($rCanciones  as $cancion)
														<?php $cantidad++; ?>
													@endforeach

													@if ( $cantidad === 1 )
														<div style="margin: auto 0;text-align:center;">
															@foreach ($rCanciones as $cancion)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
																	<div class="well well-sm well-cancion-nombre">
																		<strong>"{{ $cancion->titulo }}"</strong>
																		@include('includes.imprimir_artistas_principales')
																	</div>
																</a>
															@endforeach
														</div> 
													@elseif ( $cantidad === 2 || $cantidad === 4 )
														<div id="lfu-discos-listado-dos" style="margin: auto 0;text-align:center;">
															@foreach ($rCanciones as $cancion)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
																	<div class="well well-sm well-cancion-nombre">
																		<strong>"{{ $cancion->titulo }}"</strong>
																		@include('includes.imprimir_artistas_principales')
																	</div>
																</a>
															@endforeach
														</div> 
													@else
														<div id="lfu-discos-listado" style="margin: auto 0;text-align:center;">
															@foreach ($rCanciones as $cancion)
																<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
																	<div class="well well-sm well-cancion-nombre">
																		<strong>"{{ $cancion->titulo }}"</strong>
																		@include('includes.imprimir_artistas_principales')
																	</div>
																</a>
															@endforeach
														</div> 
													@endif
									      </div>
									    </div>
									  </div>
								  @endif
								</div>
							@else
								No se encontraron resultados.
							@endif
						@endif
					@elseif ( $rArtistas )
							<?php $cantidad = 0; ?>
							@foreach ($rArtistas as $artista)
								<?php $cantidad++; ?>
							@endforeach

							@if ( $cantidad === 1 )
								<div style="margin: auto 0;text-align:center;">
									@foreach ($rArtistas as $artista)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
											<div class="well well-sm well-artista-nombre">
												{{ $artista->nombre }}
											</div>
										</a>
									@endforeach
								</div> 
							@elseif ( $cantidad === 2 || $cantidad === 4 )
								<div id="lfu-artistas-listado-dos" style="margin: auto 0;text-align:center;">
									@foreach ($rArtistas as $artista)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
											<div class="well well-sm well-artista-nombre">
												{{ $artista->nombre }}
											</div>
										</a>
									@endforeach
								</div> 
							@else
								<div id="lfu-artistas-listado" style="margin: auto 0;text-align:center;">
									@foreach ($rArtistas as $artista)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}">
											<div class="well well-sm well-artista-nombre">
												{{ $artista->nombre }}
											</div>
										</a>
									@endforeach
								</div> 
							@endif
					@elseif ( $rDiscos )
							<?php $cantidad = 0; ?>
							@foreach ($rDiscos  as $disco)
								<?php $cantidad++; ?>
							@endforeach

							@if ( $cantidad === 1 )
								<div style="margin: auto 0;text-align:center;">
									@foreach ($rDiscos as $disco)
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
									@foreach ($rDiscos as $disco)
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
									@foreach ($rDiscos as $disco)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('discos.informacion', ['id_disco' => $disco->id]) }}">
											<div class="well well-sm well-disco-nombre">
												<strong>"{{ $disco->titulo }}"</strong> de 
												{{ (App\Disco::find($disco->id)->artista)->nombre }}
											</div>
										</a>
									@endforeach
								</div> 
							@endif
					@elseif ( $rCanciones )
							<?php $cantidad = 0; ?>
							@foreach ($rCanciones  as $cancion)
								<?php $cantidad++; ?>
							@endforeach

							@if ( $cantidad === 1 )
								<div style="margin: auto 0;text-align:center;">
									@foreach ($rCanciones as $cancion)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
											<div class="well well-sm well-cancion-nombre">
												<strong>"{{ $cancion->titulo }}"</strong>
												@include('includes.imprimir_artistas_principales')
											</div>
										</a>
									@endforeach
								</div> 
							@elseif ( $cantidad === 2 || $cantidad === 4 )
								<div id="lfu-discos-listado-dos" style="margin: auto 0;text-align:center;">
									@foreach ($rCanciones as $cancion)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
											<div class="well well-sm well-cancion-nombre">
												<strong>"{{ $cancion->titulo }}"</strong>
												@include('includes.imprimir_artistas_principales')
											</div>
										</a>
									@endforeach
								</div> 
							@else
								<div id="lfu-discos-listado" style="margin: auto 0;text-align:center;">
									@foreach ($rCanciones as $cancion)
										<a class="lfu-enlace-sin-decoracion-well" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
											<div class="well well-sm well-cancion-nombre">
												<strong>"{{ $cancion->titulo }}"</strong>
												@include('includes.imprimir_artistas_principales')
											</div>
										</a>
									@endforeach
								</div> 
							@endif
					@else
						No hay resultados.
					@endif
					<br>
				</div>

			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary lfu-panel-footer">
			<div class="panel-primary panel-footer sin-texto lfu-panel-footer" id="lfu-panel-footer"></div>
		</div>
	</div>

	

@endsection