@extends('layouts.master_usuario')

@section('titulo')
    Lyrics For Us
@endsection

@section('contenido')
    
    <div class="lfu-seccion-completa col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('includes.bloque_de_mensajes')
    </div>

    <div class="lfu-seccion-completa col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <form action="{{ route('usuario.continuar_registro') }}" method="post">
            {!! csrf_field() !!}

            {{-- Sección de Registro --}}
            <div class="panel panel-primary" id="lfu-registro-panel">
                <div class="panel-heading" id="lfu-registro-panel-heading" style="">Registro de Usuario</div>
                <div class="panel-body">

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
                        <label for="nombre">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="nombre" value="{{ Request::old('nombre') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('apellido') ? 'has-error' : '' }}">
                        <label for="nombre">Apellido</label>
                        <input class="form-control" type="text" name="apellido" id="apellido" value="{{ Request::old('apellido') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                        <label for="nickname">Nickname</label>
                        <input class="form-control" type="text" name="nickname" id="nickname" value="{{ Request::old('nickname') }}">
                    </div>
                
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">E-Mail</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 form-group {{ $errors->has('password-repeat') ? 'has-error' : '' }}">
                        <label for="password-repeat">Repetir Password</label>
                        <input class="form-control" type="password-repeat" name="password-repeat" id="password-repeat" value="{{ Request::old('password-repeat') }}">
                    </div>
                  
                <button type="submit" class="btn btn-primary">Registrarse</button>
                
                </div>
                <div class="panel-primary panel-footer" id="lfu-registro-panel-footer" style=""><a href="#" style="color:white;"> Olvidé mi contraseña </a></div>
            </div>

            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      
    </div>

    {{-- Prueba para el front-end --}}
    <h6>Resolución: 
        <span class="visible-xs">Extra-Small</span>
        <span class="visible-sm">Small</span>
        <span class="visible-md">Medium</span>
        <span class="visible-lg">Large</span>
    </h6>


@endsection