@extends('layouts.master_usuario')

@section('titulo')
   Registro | Lyrics For Us
@endsection

@section('contenido')
    
    @include('includes.bloque_de_mensajes')
    
    <div class="visible-xs visible-sm col-xs-1 visible-md col-md-2 visible-lg col-lg-3 lfu-espacio-responsive"></div>

    <div class="lfu-seccion-completa col-xs-10 col-md-8 col-lg-6">

        <form action="{{ route('usuario.continuar_registro') }}" method="post">
            {!! csrf_field() !!}

            {{-- Sección de Registro --}}
            <div class="panel panel-primary" id="lfu-panel">
                <div class="panel-heading" id="lfu-panel-heading">Registro de Usuario</div>
                <div class="panel-body">

                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
                        <label for="nombre">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="nombre" value="{{ Request::old('nombre') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('apellido') ? 'has-error' : '' }}">
                        <label for="nombre">Apellido</label>
                        <input class="form-control" type="text" name="apellido" id="apellido" value="{{ Request::old('apellido') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                        <label for="nickname">Nickname</label>
                        <input class="form-control" type="text" name="nickname" id="nickname" value="{{ Request::old('nickname') }}">
                    </div>
                
                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Correo Electrónico</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Contraseña</label>
                        <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group {{ $errors->has('password-repeat') ? 'has-error' : '' }}">
                        <label for="password-repeat">Repetir Contraseña</label>
                        <input class="form-control" type="password" name="password-repeat" id="password-repeat" value="{{ Request::old('password-repeat') }}">
                    </div>
                  
                <button type="submit" class="btn btn-primary">Registrarse</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                
                </div>
                <div class="panel-primary panel-footer sin-texto" id="lfu-panel-footer"></div>
            </div>

        </form>
      
    </div>

    <div class="visible-xs visible-sm col-xs-1 visible-md col-md-2 visible-lg col-lg-3 lfu-espacio-responsive"></div>

    {{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>


@endsection