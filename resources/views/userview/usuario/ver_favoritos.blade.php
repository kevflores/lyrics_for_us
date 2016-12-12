@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<div class="lfu-seccion-completa col-xs-12" >
		<div class="panel panel-primary" id="lfu-panel-usuario-favoritos">
			<div class="panel-heading" id="lfu-panel-usuario-favoritos-heading" style="
			border-bottom:0px;">
				<strong>
				@if ( $usuarioPerfil->id === Auth::User()->id )
					Mis Favoritos
				@else
					Favoritos de {{ $usuarioPerfil->nombre.' '.$usuarioPerfil->apellido }} ({{ $usuarioPerfil->nickname }})
				@endif
				</strong>
			</div>
		</div>
	</div>

	<div class="lfu-seccion-completa col-xs-12">
	    	
    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
    		{{-- Sección de Letras --}}
	    	<div class="panel panel-primary" id="lfu-panel-artistas-favoritos" style="">
				<div class="panel-heading" id="lfu-panel-heading-artistas-favoritos">Artistas</div>
				<div class="panel-body" id="lfu-panel-body-artistas-favoritos">
					
			    	@if ( $letrasProvistas->count() > 0 )
			    		<hr class="lfu-separador">
			    		@if ( $letrasProvistas->count() > 1 )
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto las letras de las siguientes canciones:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
			    			@endif
			    		@else
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto la letra de una canción:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
			    			@endif
			    		@endif
			    		<hr class="lfu-separador">
			    		<?php $fecha = null; ?>

				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				        
				    @else
				    	<hr class="lfu-separador">
				    	@if ( $usuarioPerfil->id === Auth::User()->id )
		    				Aún no has provisto letras a canciones.
		    			@else
		    				<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
		    			@endif
				    	{{-- Mostrar Imagen --}}
				    	<hr class="lfu-separador">
			        @endif

			    	{{--<hr class="lfu-separador">--}}
				</div>
			</div>
    	</div>

    	    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
    		{{-- Sección de Letras --}}
	    	<div class="panel panel-primary" id="lfu-panel-discos-favoritos" style="">
				<div class="panel-heading" id="lfu-panel-heading-discos-favoritos">Discos</div>
				<div class="panel-body" id="lfu-panel-body-discos-favoritos">
					
			    	@if ( $letrasProvistas->count() > 0 )
			    		<hr class="lfu-separador">
			    		@if ( $letrasProvistas->count() > 1 )
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto las letras de las siguientes canciones:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
			    			@endif
			    		@else
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto la letra de una canción:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
			    			@endif
			    		@endif
			    		<hr class="lfu-separador">
			    		<?php $fecha = null; ?>

				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				        
				    @else
				    	<hr class="lfu-separador">
				    	@if ( $usuarioPerfil->id === Auth::User()->id )
		    				Aún no has provisto letras a canciones.
		    			@else
		    				<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
		    			@endif
				    	{{-- Mostrar Imagen --}}
				    	<hr class="lfu-separador">
			        @endif

			    	{{--<hr class="lfu-separador">--}}
				</div>
			</div>
    	</div>

    	    	<div class="lfu-seccion-dividida col-xs-12 col-md-4">
    		{{-- Sección de Letras --}}
	    	<div class="panel panel-primary" id="lfu-panel-canciones-favoritas" style="">
				<div class="panel-heading" id="lfu-panel-heading-canciones-favoritas">Canciones</div>
				<div class="panel-body" id="lfu-panel-body-canciones-favoritas">
					
			    	@if ( $letrasProvistas->count() > 0 )
			    		<hr class="lfu-separador">
			    		@if ( $letrasProvistas->count() > 1 )
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto las letras de las siguientes canciones:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto las letras de las siguientes canciones:
			    			@endif
			    		@else
			    			@if ( $usuarioPerfil->id === Auth::User()->id )
			    				Tú has provisto la letra de una canción:
			    			@else
			    				<strong>{{ $usuarioPerfil->nickname }}</strong> ha provisto la letra de una canción:
			    			@endif
			    		@endif
			    		<hr class="lfu-separador">
			    		<?php $fecha = null; ?>

				    	@foreach ( $letrasProvistas as $letraProvista )
				    		@if ( $fecha == null )
				    			<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
				    			<hr class="lfu-separador" style="border-top: 0px;">
				    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    		@else
				    			@if ( $fecha == $letraProvista->fecha_letra )
				    				<hr class="lfu-separador-cancion-misma-fecha">
				    				"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }} 
				    			@else
				    				<hr class="lfu-separador" >
				    				<span class="label label-info">{{ date('d/m/Y', strtotime($letraProvista->fecha_letra)) }}</span>
					    			<hr class="lfu-separador" style="border-top: 0px;">
					    			"{{ $letraProvista->titulo }}" de {{ $letraProvista->nombre }}
				    			@endif
				    		@endif
				            <?php $fecha = $letraProvista->fecha_letra; ?>
				        @endforeach
				        <hr class="lfu-separador">
				        
				    @else
				    	<hr class="lfu-separador">
				    	@if ( $usuarioPerfil->id === Auth::User()->id )
		    				Aún no has provisto letras a canciones.
		    			@else
		    				<strong>{{ $usuarioPerfil->nickname }}</strong> aún no ha provisto letras a canciones.
		    			@endif
				    	{{-- Mostrar Imagen --}}
				    	<hr class="lfu-separador">
			        @endif

			    	{{--<hr class="lfu-separador">--}}
				</div>
			</div>
    	</div>

	</div>
    
@endsection