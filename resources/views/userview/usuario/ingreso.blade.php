@extends('layouts.master_usuario')

@section('titulo')
    Login | Lyrics For Us
@endsection

@section('contenido')

    @include('includes.bloque_de_mensajes')
    
    <div class="visible-xs visible-sm col-xs-1 visible-sm col-sm-2 visible-md col-md-3 visible-lg col-lg-3 lfu-espacio-responsive"></div>

    <div class="lfu-seccion-completa col-xs-10 col-sm-8 col-md-6 col-lg-6">

        <form action="{{ route('usuario.continuar_ingreso') }}" method="post">
            {!! csrf_field() !!}

            {{-- Sección de Login --}}
            <div class="panel panel-primary" id="lfu-panel">
                <div class="panel-heading" id="lfu-panel-heading" style="">Login de Usuario</div>
                <div class="panel-body">   

                    <div class="col-xs-12 form-group {{ $errors->has('login') ? 'has-error' : '' }}">
                        <label for="login">Nickname o Correo Electrónico</label>
                        <input class="form-control texto-centrado" type="text" name="login" id="login" value="{{ Request::old('login') }}" autofocus>
                    </div>
                    <div class="col-xs-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Contraseña</label>
                        <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                    </div>
                  
                <button type="submit" class="btn btn-primary">Ingresar</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                
                </div>
                <div class="panel-primary panel-footer" id="lfu-panel-footer" style=""><a href="{{ route('usuario.recuperar_password') }}" style="color:white;">Olvidé mi contraseña </a></div>
            </div>

        </form>
      
    </div>

    <div class="visible-xs visible-sm col-xs-1 visible-sm col-sm-2 visible-md col-md-3 visible-lg col-lg-4 lfu-espacio-responsive"></div>

    {{-- Prueba para el front-end --}}
    <h6 class="col-xs-12">Resolución: 
        <div class="visible-xs">Extra-Small</div>
        <div class="visible-sm">Small</div>
        <div class="visible-md">Medium</div>
        <div class="visible-lg">Large</div>
    </h6>
@endsection