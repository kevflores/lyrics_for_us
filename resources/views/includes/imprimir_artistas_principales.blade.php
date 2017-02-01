<?php
	$artistasPrincipales = App\Cancion::find($cancion->id)->artistas()->where('invitado', false)->orderBy('artistas.nombre')->get();
?>

@if ( $artistasPrincipales->count() > 1 )
	de 
	<?php $primerArtista = true; ?>
	@foreach ( $artistasPrincipales as $artista )
		@if ( $primerArtista === true)
			{{$artista->nombre}}
		@else
			& {{$artista->nombre}}
		@endif
		<?php $primerArtista = false; ?>
	@endforeach
@else
	@foreach ( $artistasPrincipales as $artista )
		de {{ $artista->nombre }}
	@endforeach
@endif