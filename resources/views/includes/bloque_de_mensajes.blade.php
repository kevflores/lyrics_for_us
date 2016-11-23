@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
            
                <div class="alert alert-danger alert-dismissable">
                    @foreach($errors->all() as $error)
                        <strong> - {{$error}} </strong>
                        <br>
                    @endforeach
                </div>
            
        </div>
    </div>
@endif

@if(Session::has('mensaje'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 success">
                
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
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