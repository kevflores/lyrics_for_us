<strong><span class="lfu-texto-italic">"<a href="{{ route('canciones.informacion', ['id_cancion' => $letraProvista->id] )}}" class="lfu-enlace-sin-decoracion">{{ $letraProvista->titulo }}</a>"</span></strong>
<?php 
	$id_cancion = $letraProvista->cancion_id; 
	$artistasPrincipales = App\Cancion::find($id_cancion)->artistas()->where('invitado', false)->orderBy('artistas.nombre')->get();
	$artistasInvitados = App\Cancion::find($id_cancion)->artistas()->where('invitado', true)->orderBy('artistas.nombre')->get();
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