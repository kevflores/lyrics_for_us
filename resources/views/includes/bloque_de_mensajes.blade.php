@if(count($errors) > 0)
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-4"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
            <div class="alert alert-danger alert-dismissable">
                @foreach($errors->all() as $error)
                    <strong> - {{$error}} </strong>
                    <br>
                @endforeach
            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-4"></div>
    </div>
@endif

@if(Session::has('mensaje'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 success">
                
                <div class="alert alert-success alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong> {{Session::get('mensaje')}} </strong>
                </div>
            
        </div>
    </div>
@endif

{{-- Para mostrar mensaje de Credenciales Incorrectas --}}
@if(Session::has('mensajeError'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
            
                <div class="alert alert-danger alert-dismissable">
                    <strong> {{Session::get('mensajeError')}} </strong>
                </div>
            
        </div>
    </div>
@endif