@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')

	@include('includes.bloque_de_mensajes')
    
	@if ( is_obj_empty($mensajes) )

	<form action="{{ route('borrar_mensajes_recibidos', ['mensajes' => null]) }}" method="post">
            {!! csrf_field() !!}

	<table class="table table-bordered" style="background-color:white;">
    <thead style="background-color:rgba(92, 180, 238, 1);">
      <tr>
      	<th width="10%" align="center" style="width:2%"><input type="checkbox" onclick="marcar(this);" /></th>
        <th>Asunto</th>
        <th>Remitente</th>
        <th>Fecha</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    	@foreach ($mensajes as $mensajeRecibido)
      <tr>
      	<td align="center"><input class="casilla_marcar" name ="chk[]" id="chk<?php $mensajeRecibido->id; ?>" type="checkbox" 
       	<?php
           	if (isset($this->seleccion[$mensajeRecibido->id])) {
               	echo 'checked';
            }
      	?> value="<?php echo $mensajeRecibido->id ?>" /></td>
        <td>{{ $mensajeRecibido->asunto }}</td>
        <td>
        	{{ $mensajeRecibido->usuarioEmisor()->first()->nickname }}
        </td>
        <td>{{ date('d/m/Y', strtotime($mensajeRecibido->fecha)) }} a las {{  date('H:m:s', strtotime($mensajeRecibido->fecha)) }}</td>
        <td> Borrar </td>
      </tr>
     	@endforeach
    </tbody>
  </table>

    <button type="submit" class="btn btn-primary">Enviar Marcados</button>
    <input type="hidden" name="_token" value="{{ Session::token() }}">

	</form>

	@else

		No hay mensajes (vista de prueba).

	@endif

	<script type="text/javascript">
	    function marcar(source) {
	        checkboxes=document.getElementsByClassName('casilla_marcar');
	        for(i=0;i<checkboxes.length;i++) { 
	            if(checkboxes[i].type == "checkbox") { 
	                checkboxes[i].checked=source.checked;
	            }
	        }
	    }
	</script>

@endsection