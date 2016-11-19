@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us | Usuario
@endsection

@section('contenido')
    
	<h3>Título de Prueba (Vista de Usuario)</h3>

    @for($i=0;$i<20;$i++)
        Contenido y Formulario de Prueba{{$i+1}}
    @endfor
    
    <br>
    <br>
<!--
    {!! Form::open(['url' => route('userhome'), 'method' => 'get']) !!}

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			{!! Form::label('Nombre:') !!}
			{!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Introduzca su nombre']) !!}
			<span class="text-danger">{{ $errors->first('name') }}</span>
		</div>

		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			{!! Form::label('Email:') !!}
			{!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Introduzca su email']) !!}
			<span class="text-danger">{{ $errors->first('email') }}</span>
		</div>

		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
			{!! Form::label('Mensaje:') !!}
			{!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Introduzca su nombre', 'style' => 'resize: none;']) !!}
			<span class="text-danger">{{ $errors->first('message') }}</span>
		</div>

		<div class="form-group">
			<button class="btn btn-primary" style="border-radius: 30px; width: 100px;">Enviar</button>
		</div>

	{!! Form::close() !!}
-->
@endsection