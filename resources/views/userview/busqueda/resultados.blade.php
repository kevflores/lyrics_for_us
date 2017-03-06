@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Mostrar Resultados</h3>
	<br>
	<br>
	@if ( $resultados )
		{{ $resultados }}
	@endif
	<br>
	<br>

	NOTA: Crear un panel group con toggle para mostrar los resultados divididos, en caso de que el usuario haya seleccionado TODO como tipo de búsqueda.

	<br>
	<br>
	@if ( $rCanciones )
		@foreach ( $rCanciones as $cancion )
			{{ $cancion->titulo }}
			<hr class="lfu-separador">
		@endforeach
	@endif
    
@endsection