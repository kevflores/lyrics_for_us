@extends('layouts.master_usuario')

@section('titulo')
    Inicio | Lyrics For Us
@endsection

@section('contenido')

    @include('includes.bloque_de_mensajes')

    <div class="lfu-seccion-completa col-xs-12">

    <div class="well" style="border-color: rgba(68, 154, 208, 1);">
    	<strong>Lyrics For Us</strong> es un aplicación web que permite conectar a los amantes de la música, especialmente a aquellas personas interesadas en las letras de las canciones de sus artistas favoritos. Los usuarios de esta aplicación pueden contribuir aportando las letras de las canciones que aún no posean una, así como interactuar con otros usuarios registrados a través de comentarios y mensajes privados.
    </div>

    </div>

	<div class="lfu-seccion-completa col-xs-12">
    	
		<div class="lfu-seccion-dividida col-xs-12 col-sm-6" style="">
    		{{-- Sección de últimas letras agregadas --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-ultimasletras">
				<div class="panel-heading" id="lfu-inicio-panel-heading-ultimasletras">Últimas letras publicadas</div>
				<div class="panel-body" id="lfu-inicio-panel-body-ultimasletras" style="">
					@if ( $ultimasLetras->count() > 0 )
						@foreach ( $ultimasLetras as $letra )
							<span class="dato-inicio">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $letra->cancion_id]) }}">
									@if (Storage::disk('img-canciones')->has($letra->portada))
							            <img src="{{ route('canciones.imagen', ['imagenNombre' => 'thumbnail_'.$letra->portada]) }}" alt="{{ $letra->titulo }}" class="img-circle img-dato-inicio">
									@else
										<img src="{{ asset('images\lfu-default-cancion.png') }}" alt="{{ $letra->titulo }}" class="img-circle img-dato-inicio">
									@endif
									<span style="font-style:italic;">
										<strong>"{{ $letra->titulo }}"</strong>
									</span>
								</a>
								@include('includes.imprimir_artistas_principales_ultimas_letras')
							</span>
							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						<hr class="lfu-separador">
						Aún no hay letras de canciones registradas.
						<hr class="lfu-separador">
					@endif
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-6">
    		{{-- Sección de top de canciones --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-topcanciones">
				<div class="panel-heading" id="lfu-inicio-panel-heading-topcanciones">Top de canciones favoritas</div>
				<div class="panel-body" id="lfu-inicio-panel-body-topcanciones">
					
					@if ( $topCancionesFavoritas->count() > 0 )
						@foreach ( $topCancionesFavoritas as $cancion )
							<span class="dato-inicio">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('canciones.informacion', ['id_cancion' => $cancion->id]) }}">
									@if (Storage::disk('img-canciones')->has($cancion->portada))
							            <img src="{{ route('canciones.imagen', ['imagenNombre' => 'thumbnail_'.$cancion->portada]) }}" alt="{{ $cancion->titulo }}" class="img-circle img-dato-inicio">
									@else
										<img src="{{ asset('images\lfu-default-cancion.png') }}" alt="{{ $cancion->titulo }}" class="img-circle img-dato-inicio">
									@endif
									<span style="font-style:italic;">
										<strong>"{{ $cancion->titulo }}"</strong>
									</span>
								</a>
								@include('includes.imprimir_artistas_principales_canciones_favoritas')
							</span>
							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						<hr class="lfu-separador">
						Aún no hay canciones favoritas.
						<hr class="lfu-separador">
					@endif
					
				</div>
		    </div>
		    {{-- Sección de top de usuarios colaboradores --}}
	    	<div class="panel panel-primary" id="lfu-inicio-panel-topusuarios">
				<div class="panel-heading" id="lfu-inicio-panel-heading-topusuarios">Top de usuarios colaboradores</div>
				<div class="panel-body" id="lfu-inicio-panel-body-topusuarios">
					
					@if ( $topUsuariosColaboradores->count() > 0 )
						@foreach ( $topUsuariosColaboradores as $colaborador )
							<span class="dato-inicio">
								<a class="lfu-enlace-sin-decoracion" href="{{ route('usuario.perfil', ['nickname' => $colaborador->nickname]) }}">
									@if (Storage::disk('avatars')->has($colaborador->imagen))
							            <img src="{{ route('usuario.avatar', ['imagenNombre' => 'thumbnail_'.$colaborador->imagen]) }}" alt="{{ $colaborador->nickname }}" class="img-circle img-dato-inicio">
									@else
										<img src="{{ asset('images\lfu-default-avatar.png') }}" alt="{{ $colaborador->nickname }}" class="img-circle img-dato-inicio">
									@endif
									@if ( $usuario )
										@if ( $usuario->id === $colaborador->id )
											Tú
										@else
											{{ $colaborador->nombre }} {{ $colaborador->apellido }} 
										@endif
									@else
									{{ $colaborador->nombre }} {{ $colaborador->apellido }} 
									@endif
									<strong>({{ $colaborador->nickname }})</strong>
								</a>
							</span>
							<hr class="lfu-separador-datos-inicio">
						@endforeach
					@else
						<hr class="lfu-separador">
						Aún no hay usuarios colaboradores.
						<hr class="lfu-separador">
					@endif
					
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