@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if(Session::has('mensaje'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 success">
        <ul>    
            {{Session::get('mensaje')}}
        </ul>
        </div>
    </div>
@endif

@if(Session::has('mensajeError'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
        <ul>    
            {{Session::get('mensajeError')}}
        </ul>
        </div>
    </div>
@endif