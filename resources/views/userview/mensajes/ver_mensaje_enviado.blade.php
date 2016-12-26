@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
<div class="btn-group lfu-botones-mensajes" style="margin-bottom:25px;">
    <a href="{{ route('mensajes_recibidos') }}" class="btn btn-primary"><strong>Mensajes recibidos</strong></a>
    <a href="{{ route('mensajes_enviados') }}" class="btn btn-primary active">Mensajes enviados</a>
</div>

@include('includes.bloque_de_mensajes')
@include('includes.modal_eliminar_mensaje_enviado_lectura')

	<div class="col-xs-12" style="text-align:right;padding:0px;" data-idmensaje="{{ $mensaje->id }}" data-asunto="{{ $mensaje->asunto }}">
		<button type="submit" class="btn btn-primary" id="eliminar-mensaje-enviado-boton" style="margin-bottom:5px;">Eliminar</button>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
    	<div class="panel panel-primary" id="lfu-panel-mensaje">
			<div class="panel-heading" id="lfu-panel-mensaje-heading"><strong>Mensaje para <a class="lfu-enlace-sin-decoracion" style="color:white;" href="{{ route('usuario.perfil', ['nickname' => $mensaje->usuarioReceptor()->first()->nickname]) }}">{{ $mensaje->usuarioReceptor()->first()->nickname }}</a></strong></div>
			<div class="panel-body">
				<strong>Para: </strong><span class="info-mensaje">{{ $mensaje->usuarioReceptor()->first()->nombre." ".$mensaje->usuarioReceptor()->first()->apellido." (".$mensaje->usuarioReceptor()->first()->nickname.")" }}</span>
				<br>
				<strong>De: </strong><span class="info-mensaje">Mí</span>
				<br> 
				<strong>Asunto: </strong><span class="info-mensaje">"{{ $mensaje->asunto }}"</span>
				<br>
				<strong>Fecha: </strong><span class="info-mensaje">{{ date('d/m/Y', strtotime($mensaje->fecha)) }} a las {{  date('h:i A', strtotime($mensaje->fecha)) }}</span>
				<br>
				<hr class="lfu-separador">
				{{ $mensaje->descripcion }}
				<hr class="lfu-separador">
			</div>
		</div>
	</div>
    
@endsection