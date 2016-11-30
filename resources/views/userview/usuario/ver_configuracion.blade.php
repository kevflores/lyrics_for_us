@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12">
    	
		<div class="lfu-seccion-dividida col-xs-12 col-sm-8" style="">
    		{{-- Sección de configuración de datos --}}
	    	<div class="panel panel-primary" id="lfu-configuracion-panel-datos">
				<div class="panel-heading" id="lfu-configuracion-panel-heading-datos">Configuración</div>
				<div class="panel-body" id="lfu-configuracion-panel-body-datos" style="">
					<hr>
					@for($i=0;$i<5;$i++)
				        Dato N° {{$i+1}}
				        <br>
			    	@endfor
				    <br>
					<button type="submit" class="btn btn-primary">Actualizar datos</button>
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