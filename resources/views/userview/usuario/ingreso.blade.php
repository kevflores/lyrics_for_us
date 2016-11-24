@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
	<h3>Login</h3>
    <br>
    @include('includes.bloque_de_mensajes')
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <form action="{{ route('usuario.continuar_ingreso') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group {{ $errors->has('login') ? 'has-error' : '' }}">
                    <label for="login">Nombre de Usuario o  E-Mail</label>
                    <input class="form-control" type="text" name="login" id="login" value="{{ Request::old('login') }}" autofocus>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Contraseña</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                </div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
@endsection