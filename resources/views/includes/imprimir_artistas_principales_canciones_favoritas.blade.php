<?php
	$artistasPrincipales = App\Cancion::find($cancion->id)->artistas()->where('invitado', false)->orderBy('artistas.nombre')->get();
?>

@if ( $artistasPrincipales->count() > 1 )
	de 
	<?php $primerArtista = true; ?>
	@foreach ( $artistasPrincipales as $artista )
		@if ( $primerArtista === true)
			<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{$artista->nombre}}</a>	
		@else
			& <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{$artista->nombre}}</a>	
		@endif
		<?php $primerArtista = false; ?>
	@endforeach
@else
	@foreach ( $artistasPrincipales as $artista )
		de <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{$artista->nombre}}</a>	
	@endforeach
@endif