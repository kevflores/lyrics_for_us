{{-- Mostrar mensajes de error --}}
@if(count($errors) > 0)
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-danger alert-dismissable mensaje-de-validacion">
                @foreach($errors->all() as $error)
                    <strong> - {{$error}} </strong>
                    <br>
                @endforeach
            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif

{{-- Mostrar mensaje de éxito --}}
@if(Session::has('mensaje'))
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{Session::get('mensaje')}} </strong>
            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif

{{-- Mostrar confirmación de mensaje enviado a usuario --}}
@if(Session::has('mensajeEnviado'))
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                
                <strong> El <a href="{{ route('ver_mensaje_enviado', ['id_mensaje' => Session::get('mensajeEnviado')]) }}">mensaje</b></a> ha sido enviado correctamente. </strong>

            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif

{{-- Mostrar mensajes de credenciales incorrectas --}}
@if(Session::has('mensajeError'))
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-danger alert-dismissable mensaje-de-validacion">
                <strong> {{Session::get('mensajeError')}} </strong>
            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif

{{-- Mostrar mensaje de prueba --}}
@if(Session::has('mensajeInfo'))
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{Session::get('mensajeInfo')}} </strong>
            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif