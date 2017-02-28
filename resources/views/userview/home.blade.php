@extends('layouts.master_usuario')

@section('titulo')
    Inicio | Lyrics For Us
@endsection

@section('contenido')

    @include('includes.bloque_de_mensajes')

	<div class="lfu-seccion-completa col-xs-12">
    	
		<div class="lfu-seccion-dividida col-xs-12 col-sm-6" style="">
    		{{-- Sección de últimas letras agregadas --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-ultimasletras">
				<div class="panel-heading" id="lfu-inicio-panel-heading-ultimasletras">Últimas letras publicadas</div>
				<div class="panel-body" id="lfu-inicio-panel-body-ultimasletras" style="">
					<hr class="lfu-separador">
					@if ( $ultimasLetras->count() > 0 )
						@foreach ( $ultimasLetras as $letra )
							<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $letra->cancion_id]) }}">
								<span style="font-style:italic;">
									<strong>"{{ $letra->titulo }}"</strong>
								</span>
							</a>
							@include('includes.imprimir_artistas_principales_ultimas_letras')

							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						Aún no hay letras registradas.
					@endif
					<hr class="lfu-separador">
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-6">
    		{{-- Sección de top de canciones --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-topcanciones">
				<div class="panel-heading" id="lfu-inicio-panel-heading-topcanciones">Top de canciones favoritas</div>
				<div class="panel-body" id="lfu-inicio-panel-body-topcanciones">
					<hr class="lfu-separador">
					@if ( $topCancionesFavoritas->count() > 0 )
						@foreach ( $topCancionesFavoritas as $cancion )
							<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
								<span style="font-style:italic;">
									<strong>"{{ $cancion->titulo }}"</strong>
								</span>
							</a>
							@include('includes.imprimir_artistas_principales_canciones_favoritas')

							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						Aún no hay canciones favoritas.
					@endif
					<hr class="lfu-separador">
				</div>
		    </div>
		    {{-- Sección de top de usuarios colaboradores --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-topusuarios">
				<div class="panel-heading" id="lfu-inicio-panel-heading-topusuarios">Top de usuarios colaboradores</div>
				<div class="panel-body" id="lfu-inicio-panel-body-topusuarios">
					<hr class="lfu-separador">
					@if ( $topUsuariosColaboradores->count() > 0 )
						@foreach ( $topUsuariosColaboradores as $usuario )
							<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $usuario->nickname]) }}">
									{{ $usuario->nombre }} <strong>({{ $usuario->nickname }})</strong>
							</a>
							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						Aún no hay canciones favoritas.
					@endif
					<hr class="lfu-separador">
				</div>
		    </div>		    
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary lfu-panel-footer">
			<div class="panel-primary panel-footer sin-texto lfu-panel-footer" id="lfu-panel-footer"></div>
		</div>
	</div>

    {{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>

    {{--

    {!! Form::open(['url' => route('userhome'), 'method' => 'get']) !!}

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			{!! Form::label('Nombre:') !!}
			{!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Introduzca su nombre']) !!}
			<span class="text-danger">{{ $errors->first('name') }}</span>
		</div>

		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			{!! Form::label('Email:') !!}
			{!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Introduzca su email']) !!}
			<span class="text-danger">{{ $errors->first('email') }}</span>
		</div>

		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
			{!! Form::label('Mensaje:') !!}
			{!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Introduzca su nombre', 'style' => 'resize: none;']) !!}
			<span class="text-danger">{{ $errors->first('message') }}</span>
		</div>

		<div class="form-group">
			<button class="btn btn-primary">Enviar</button>
		</div>

	{!! Form::close() !!}

	--}}


@endsection