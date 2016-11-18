<header>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            </div>
        @endif

        <div id="menu-usuario" class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('home') }}">Lyrics For Us</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse navbar-menubuilder">
                    <ul class="nav navbar-nav navbar-left">
                        <li {{ current_page("inicio") ? 'class=active' : '' }}><a href="{{ route('userhome') }}">Inicio</a></li>
                        <li {{ current_page("artistas") ? 'class=active' : '' }}><a href="{{ route('artistas') }}">Artistas</a></li>
                        <li {{ current_page("discos") ? 'class=active' : '' }}><a href="{{ route('discos') }}">Discos</a></li>
                        <li {{ current_page("canciones") ? 'class=active' : '' }}><a href="{{ route('canciones') }}">Canciones</a></li>
                        <li {{ current_page("registro") ? 'class=active' : '' }}><a href="{{ route('usuario.registro') }}">Registro</a></li>
                        <li class="dropdown" >
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mi cuenta <span class="caret"></span>
                          </a>
                          <ul id="mi-cuenta" class="dropdown-menu">
                            <li class="text-center">
                                {{--
                                @if ($usuario)
                                    <a>{{ $usuario->nickname }}</a>
                                @else
                                    <a>Nombre de usuario</a>
                                @endif
                                --}}
                                <a> nickname</a>
                            </li>
                            <li role="separator" class="divider"></li>
                                {{--
                                @if ($usuario)
                                    <li><a href="{{ route('usuario.perfil', ['nickname' => $usuario->nickname]) }}">Ver mi perfil</a></li>
                                @else
                                    <li><a href="#">Ver mi perfil</a></li>                                
                                @endif
                                --}}
                            <li {{ current_page("cuenta") ? "style='background-colo:black;'"  : '' }}><a href="#">Ver mi perfil</a></li>   
                            <li><a href="{{ route('mensajes_recibidos') }}">Mensajes privados</a></li>
                            <li><a href="{{ route('usuario.solicitudes') }}">Mis solicitudes</a></li>
                            <li><a href="{{ route('usuario.configuracion') }}">Configuración</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('usuario.salir') }}">Salir</a></li>
                          </ul>
                        </li>
                        <li {{ current_page("ingreso") ? 'class=active' : '' }}><a href="{{ route('usuario.ingreso') }}">Login</a></li>
                    </ul>
                    {!! Form::open(['url' => route('buscar'), 'method' => 'get' /*, 'class' => 'navbar-form navbar-right'*/]) !!}
                        <div class="navbar-form navbar-right">
                            <div class="form-group">
                              <input type="text" class="form-control" placeholder="Artista, disco, canción..." style="width: 200px;">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>

                    <ul class="nav navbar-nav navbar-right searcher">
                        <li {{ current_page("buscar") ? 'class=active' : '' }}>
                            <a href="{{ route('buscar') }}"><span class="glyphicon glyphicon-search"></span></a>
                        </li>
                    </ul>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</header>