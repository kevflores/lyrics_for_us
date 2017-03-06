<header>
    <div class="flex-center position-ref full-height">
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
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (!$usuario)
                            <li {{ current_page("ingreso") ? 'class=active' : '' }}><a href="{{ route('usuario.ingreso') }}">Login</a></li>
                            <li {{ current_page("registro") ? 'class=active' : '' }}><a href="{{ route('usuario.registro') }}">Registro</a></li>
                        @else
                            <li class="dropdown" >
                              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mi cuenta <span class="caret"></span>
                              </a>
                              <ul id="mi-cuenta" class="dropdown-menu">
                                <li><a id="mi-cuenta-nickname">Usuario: {{ $usuario->nickname }}</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('usuario.perfil', ['nickname' => $usuario->nickname]) }}">Ver mi perfil</a></li>
                                <li><a href="{{ route('mensajes_recibidos') }}">Mis mensajes</a></li>
                                <li><a href="{{ route('usuario.solicitudes') }}">Mis solicitudes</a></li>
                                <li><a href="{{ route('usuario.ver_favoritos', ['nickname' => $usuario->nickname]) }}">Mis favoritos</a></li>
                                <li><a href="{{ route('usuario.configuracion') }}">Configuración</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('usuario.salir') }}">Salir</a></li>
                              </ul>
                            </li>
                        @endif
                        <li {{ current_page("buscar") ? 'class=active' : '' }}>
                            <a href="{{ route('buscar') }}"><span class="glyphicon glyphicon-search"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>