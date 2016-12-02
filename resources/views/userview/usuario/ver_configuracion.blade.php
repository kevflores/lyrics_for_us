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
							{!! Form::textarea('resumen', $usuario->resumen, ['class'=>'form-control', 'placeholder'=>'Cuenta un poco sobre ti.', 'style' => 'resize: none; height: 75px;']) !!}
							<span class="text-danger">{{ $errors->first('resumen') }}</span>
						</div>

						<div class="form-group">
							<button class="btn btn-primary">Actualizar datos</button>
						</div>

					{!! Form::close() !!}

				</div>
			</div>
			{{-- Sección de configuración de correo electrónico --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-correo">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-correo">Correo electrónico</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-correo">
					{!! Form::open(['url' => route('usuario.actualizar_datos'), 'method' => 'post']) !!}

						<div class="form-group col-md-6 col-md-offset-3 {{ $errors->has('email') ? 'has-error' : '' }}">
							{!! Form::label('email','Correo Electrónico', array('class'=>'label-izquierda')) !!}
							{!! Form::text('email', $usuario->email, ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('email') }}</span>
						</div>

						<div class="form-group col-md-6 col-md-offset-3 {{ $errors->has('email-repeat') ? 'has-error' : '' }}">
							{!! Form::label('email-repeat','Repetir Correo Electrónico', array('class'=>'label-izquierda')) !!}
							{!! Form::text('email-repeat', old('email-repeat'), ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
							<span class="text-danger">{{ $errors->first('email-repeat') }}</span>
						</div>

						<div class="form-group">
							<button class="btn btn-primary">Actualizar correo electrónico</button>
						</div>

					{!! Form::close() !!}
				</div>
			</div>
    	</div>

    	<div class="lfu-seccion-dividida col-xs-12 col-sm-4">
    		{{-- Sección de config. imagen de perfil --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-imagen">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-imagen">Imagen de perfil</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-imagen">
					@if ( $usuario->imagen )
						<img class="img-responsive img-rounded lfu-avatar" src="{{ asset($usuario->imagen) }}" alt="$usuario->nickname">
					@else
						<img class="img-responsive img-rounded lfu-avatar" src="{{ asset('images\lfu-default-avatar.png') }}" alt="$usuario->nickname" >
					@endif
					<button type="submit" class="btn btn-primary">Subir nueva imagen</button>
					<a style="display:block;margin-top:15px;"><button class="btn btn-primary">Borrar imagen</button></a>
				</div>
		    </div>
		    {{-- Sección de config. de contraseña --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-password">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-password">Contraseña</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-password">
					<div class="form-group col-md-12 {{ $errors->has('password-new') ? 'has-error' : '' }}">
						{!! Form::label('password-new','Nueva Contraseña', array('class'=>'label-izquierda')) !!}
						{!! Form::text('password-new', old('password-new'), ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
						<span class="text-danger">{{ $errors->first('password-new') }}</span>
					</div>
					<div class="form-group col-md-12 {{ $errors->has('password-repeat') ? 'has-error' : '' }}">
						{!! Form::label('password-repeat','Repetir Nueva Contraseña', array('class'=>'label-izquierda')) !!}
						{!! Form::text('password-repeat', old('password-repeat'), ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
						<span class="text-danger">{{ $errors->first('password-repeat') }}</span>
					</div>
					<button type="submit" class="btn btn-primary">Actualizar contraseña</button>
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