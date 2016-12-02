@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	@include('includes.bloque_de_mensajes')

	<div class="lfu-seccion-completa col-xs-12">
    	
		<div class="lfu-seccion-dividida col-xs-12 col-sm-8" style="">
    		{{-- Sección de configuración de datos --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-datos">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-datos">Configuración</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-datos">
					{!! Form::open(['url' => route('usuario.actualizar_datos'), 'method' => 'post']) !!}

						<div class="form-group col-md-6 {{ $errors->has('nombre') ? 'has-error' : '' }}">
							{!! Form::label('nombre','Nombre', array('class'=>'label-izquierda')) !!}
							{!! Form::text('nombre', $usuario->nombre, ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('nombre') }}</span>
						</div>

						<div class="form-group col-md-6 {{ $errors->has('apellido') ? 'has-error' : '' }}">
							{!! Form::label('apellido','Apellido', array('class'=>'label-izquierda')) !!}
							{!! Form::text('apellido', $usuario->apellido, ['class'=>'form-control','style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('apellido') }}</span>
						</div>

						<div class="form-group col-md-6 {{ $errors->has('nickname') ? 'has-error' : '' }}">
							{!! Form::label('nickname','Nickname', array('class'=>'label-izquierda')) !!}
							{!! Form::text('nickname', $usuario->nickname, ['class'=>'form-control','style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('nickname') }}</span>
						</div>

						<div class="form-group col-md-6 {{ $errors->has('url') ? 'has-error' : '' }}">
							{!! Form::label('url','URL', array('class'=>'label-izquierda')) !!}
							{!! Form::text('url', $usuario->url, ['class'=>'form-control','style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('url') }}</span>
						</div>

						<div class="form-group col-md-12 {{ $errors->has('resumen') ? 'has-error' : '' }}">
							{!! Form::label('resumen','Resumen', array('class'=>'label-izquierda')) !!}
							{!! Form::textarea('resumen', $usuario->resumen, ['class'=>'form-control', 'placeholder'=>'Cuenta un poco sobre ti.', 'style' => 'resize: none;']) !!}
							<span class="text-danger">{{ $errors->first('resumen') }}</span>
						</div>

						<div class="form-group">
							<button class="btn btn-primary">Actualizar datos</button>
						</div>

					{!! Form::close() !!}

					<hr>
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de config. imagen de perfil --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-imagen">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-imagen">Imagen de perfil</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-imagen">
					@for($i=0;$i<5;$i++)
				        Imagen N° {{$i+1}}
				        <br>
			    	@endfor
				    <br>
					<button type="submit" class="btn btn-primary">Subir nueva imagen</button>
					<hr>
				</div>
		    </div>
		    {{-- Sección de config. de contraseña --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-password">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-password">Contraseña</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-password">
					@for($i=0;$i<5;$i++)
				        Contraseña N° {{$i+1}}
				        <br>
			    	@endfor
				    <br>
					<button type="submit" class="btn btn-primary">Actualizar contraseña</button>
					<hr>
				</div>
		    </div>		    
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary panel-footer-configuracion">
			<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
		</div>
	</div>

    {{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>

@endsection