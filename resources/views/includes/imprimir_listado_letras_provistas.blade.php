<strong><span class="lfu-texto-italic">"<a href="{{ route('canciones.informacion', ['id_cancion' => $letraProvista->cancion_id] )}}" class="lfu-enlace-sin-decoracion">{{ $letraProvista->titulo }}</a>"</span></strong>
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
			<a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
		@else
			& <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
		@endif
		<?php $primerArtista = false; ?>
	@endforeach
@else
	@foreach ( $artistasPrincipales as $artista )
		de <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
	@endforeach
@endif

@if ( $artistasInvitados->count() > 1 )
	<?php $primerArtista = true; ?>
	@foreach ( $artistasInvitados as $artista )
		@if ( $primerArtista === true)
			(feat. <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>
		@else
			& <span><a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{$artista->nombre}}</a></span>@endif<?php $primerArtista = false; ?>@endforeach<span>)</span> {{-- No se colocan saltos de línea aquí, debido a que dejaría un espacio antes del cierre de paréntesis --}}
@else
	@foreach ( $artistasInvitados as $artista )
		(feat. <a class="lfu-enlace-sin-decoracion" href="{{ route('artistas.informacion', ['id_artista' => $artista->id]) }}" title="">{{ $artista->nombre }}</a>)
	@endforeach
@endif