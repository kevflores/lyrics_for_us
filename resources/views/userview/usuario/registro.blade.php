@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Registro (Vista de Usuario)</h3>
	<br>
	@include('includes.message-block')
    <div class="row">
    	<div class="col-md-4">
    	</div>
        <div class="col-md-4">
            <form action="{{ route('usuario.continuar_registro') }}" method="post">
                <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="{{ Request::old('nombre') }}">
                </div>
                <div class="form-group {{ $errors->has('apellido') ? 'has-error' : '' }}">
                    <label for="nombre">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="{{ Request::old('apellido') }}">
                </div>
                <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                    <label for="nickname">Nickname</label>
                    <input class="form-control" type="text" name="nickname" id="nickname" value="{{ Request::old('nickname') }}">
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-Mail</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
                </div>
                
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
        <div class="col-md-4">
    	</div>
    </div>
@endsection