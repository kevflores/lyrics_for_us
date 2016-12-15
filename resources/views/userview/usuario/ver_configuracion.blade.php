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
					{!! Form::open(['url' => route('usuario.actualizar_datos'), 'method' => 'post', 'id' => 'lfu-form-config-datos']) !!}

						<div class="form-group col-md-6 {{ $errors->has('nombre') ? 'has-error' : '' }}">
							{!! Form::label('nombre','Nombre', array('class'=>'label-izquierda')) !!}
							{!! Form::text('nombre', $usuario->nombre, ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
							{{-- <span class="text-danger">{{ $errors->first('nombre') }}</span> --}}
						</div>

						<div class="form-group col-md-6 {{ $errors->has('apellido') ? 'has-error' : '' }}">
							{!! Form::label('apellido','Apellido', array('class'=>'label-izquierda')) !!}
							{!! Form::text('apellido', $usuario->apellido, ['class'=>'form-control','style' => 'text-align:left;']) !!}
						</div>

						<div class="form-group col-md-6 {{ $errors->has('ubicacion') ? 'has-error' : '' }}">
							{!! Form::label('ubicacion','Ubicación', array('class'=>'label-izquierda')) !!}
							{!! Form::text('ubicacion', $usuario->ubicacion, ['class'=>'form-control','style' => 'text-align:left;']) !!}
						</div>

						<div class="form-group col-md-6 {{ $errors->has('url') ? 'has-error' : '' }}">
							{!! Form::label('url','URL', array('class'=>'label-izquierda')) !!}
							{!! Form::text('url', $usuario->url, ['class'=>'form-control','style' => 'text-align:left;']) !!}
						</div>

						<div class="form-group col-md-12 {{ $errors->has('resumen') ? 'has-error' : '' }}">
							{!! Form::label('resumen','Resumen', array('class'=>'label-izquierda')) !!}
							{!! Form::textarea('resumen', $usuario->resumen, ['class'=>'form-control', 'placeholder'=>'Cuenta un poco sobre ti.', 'style' => 'resize: none; height: 75px;']) !!}
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
					{!! Form::open(['url' => route('usuario.actualizar_correo'), 'method' => 'post',  'novalidate' => true, 'id' => 'lfu-form-config-correo']) !!}

						<div class="form-group col-md-6 col-md-offset-3 {{ $errors->has('email') ? 'has-error' : '' }} <?php if (Session::has('correoActual')) { echo "has-error"; } ?>">
							{!! Form::label('email','Correo electrónico', array('class'=>'label-izquierda')) !!}
							{!! Form::email('email', $usuario->email, ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
						</div>

						<div class="form-group col-md-6 col-md-offset-3 {{ $errors->has('email-repeat') ? 'has-error' : ''}}">
							{!! Form::label('email-repeat','Repetir correo electrónico', array('class'=>'label-izquierda')) !!}
							{!! Form::email('email-repeat', old('email-repeat'), ['class'=>'form-control', 'style' => 'text-align:left;']) !!}
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
					
					{{-- Si el usuario tiene una imagen de perfil registrada en la BD --}}
					@if (Storage::disk('avatars')->has($usuario->imagen))
						{!! Form::open(['url' => route('usuario.eliminar_avatar'), 'method' => 'post', 'id' => 'lfu-form-eliminar-imagen']) !!}

						<div class="container-img">
							<img src="{{ route('usuario.avatar', ['imagenNombre' => $usuario->imagen]) }}" alt="{{ $usuario->nickname }}" class="img-responsive img-rounded lfu-avatar" id="lfu-avatar-editable">
							<span class="enlace-sobre-avatar img-rounded" id="lfu-eliminar-imagen">
								Eliminar imagen
							</span>

							@include('includes.modal_eliminar_imagen')

						</div>

						{!! Form::close() !!}
					{{-- Sino, sólo se muestra una imagen de perfil por defecto --}}
					@else
						<img class="img-responsive img-rounded lfu-avatar" src="{{ asset('images\lfu-default-avatar.png') }}" alt="{{ $usuario->nickname }}" style="margin-bottom:15px;">
					@endif

					{{-- Formulario para subir una nueva imagen --}}
					{!! Form::open(['url' => route('usuario.actualizar_imagen'), 'method' => 'post', 'files' => true, 'id' => 'lfu-form-config-imagen']) !!}

						<div class="form-group col-xs-12 {{ $errors->has('imagen') ? 'has-error' : '' }}">
							<div class="form-control seleccionarImagen">
							    <span class="spanImagen">Seleccionar imagen</span>
							    <input type="file" name="imagen" class="subirImagen"/>
							</div>
        				</div>

	        			{!! Form::token() !!}
						<button type="submit" class="btn btn-primary">Subir nueva imagen</button>

					{!! Form::close() !!}

				</div>
		    </div>
		    
		    {{-- Sección de config. de contraseña --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-password">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-password">Contraseña</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-password">
					{!! Form::open(['url' => route('usuario.actualizar_password'), 'method' => 'post', 'id' => 'lfu-form-config-password']) !!}

						<div class="col-xs-12 form-group {{ $errors->has('password-new') ? 'has-error' : '' }}">
	                        <label for="password-new" class="label-izquierda">Nueva contraseña</label>
	                        <input class="form-control texto-centrado" type="password" name="password-new" id="password-new" value="{{ Request::old('password-new') }}" style="text-align:left;">
	                    </div>

						<div class="col-xs-12 form-group {{ $errors->has('password-repeat') ? 'has-error' : '' }}">
	                        <label for="password-repeat" class="label-izquierda">Repetir nueva contraseña</label>
	                        <input class="form-control texto-centrado" type="password" name="password-repeat" id="password-new" value="{{ Request::old('password-repeat') }}" style="text-align:left;">
	                    </div>

						<a class="btn btn-primary" id="lfu-actualizarPassword">Actualizar contraseña</a>

						<!-- Modal para crear comentario en el perfil del usuario -->
						<div class="modal fade" id="actualizarPasswordModal" role="dialog">
							<div class="modal-dialog">
							<!-- Contenido del Modal-->
								<div class="modal-content">
									<div class="modal-header" >
										<button type="button" class="close cerrar_modal_actpass" data-dismiss="modal">&times;</button>
										<h4><span class="glyphicon glyphicon-check"></span> Confirmar cambio de contraseña</h4>
									</div>
									<div class="modal-body" >
										<div class="col-xs-12 form-group {{ $errors->has('password-actual') ? 'has-error' : '' }} ">
											<label for="password-actual" class="label-izquierda">Contraseña actual</label>
	                        				<input class="form-control texto-centrado" type="password" name="password-actual" id="password-actual" style="text-align:left;">
										</div>
										<button type="button" class="btn btn-danger" id="cancelar-actualizacion" data-dismiss="modal">Cancelar</button>
										<button class="btn btn-primary" id="enviarNuevaPassword" >Enviar</button>
									</div>
								</div>
							</div>
						</div> 

					{!! Form::close() !!}
				</div>
		    </div>		    
    	</div>

	</div>

	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary panel-footer-configuracion">
			<div class="panel-primary panel-footer sin-texto panel-footer-configuracion" id="lfu-panel-footer"></div>
		</div>
	</div>

@endsection