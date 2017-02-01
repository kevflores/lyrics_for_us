<?php
	$artistasInvitados = App\Cancion::find($cancion->id)->artistas()->where('invitado', true)->orderBy('artistas.nombre')->get();
?>

@if ( $artistasInvitados->count() > 1 )
	{{-- En las siguientes líneas no se usa el código Blade, con la intención de poder
	agrupar los nombres de todos los artistas invitados en una canción e imprimirlos
	correctamente dentro de los paréntesis sin dejar espacios en blanco que los separen de éstos. --}}
	<?php
		$primerArtista = true;
		foreach ( $artistasInvitados as $artista ) {
			if ( $primerArtista === true)
				$invitados = $artista->nombre;
			else
				$invitados= $invitados." & ".$artista->nombre;
			$primerArtista = false;
		}
	?>
	(feat. {{$invitados}})
@else
	@foreach ( $artistasInvitados as $artista )
		(feat. {{ $artista->nombre }})
	@endforeach
@endif