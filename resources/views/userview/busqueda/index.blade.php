@extends('layouts.master_usuario')

@section('titulo')
    Búsqueda | Lyrics For Us
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
						   old('tipo_busqueda'), ['class'=>'form-control']); !!}
					</div>

			    	<div class="form-group col-xs-12 col-sm-6 {{ $errors->has('palabra_clave') ? 'has-error' : '' }}">
						{!! Form::label('palabra_clave','Palabras Clave', array('class'=>'label-izquierda', )) !!}
						{!! Form::text('palabra_clave', old('palabra_clave'), ['class'=>'form-control', 'style' => 'text-align:left;', 'id' => 'lfu-palabra-clave']) !!}
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
    	<div class="panel panel-primary lfu-panel-footer">
			<div class="panel-primary panel-footer sin-texto lfu-panel-footer" id="lfu-panel-footer"></div>
		</div>
	</div>
    
@endsection