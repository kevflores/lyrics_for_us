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
                    <a class="navbar-brand" href="#">Lyrics For Us</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse navbar-menubuilder">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="active"><a href="#">Inicio</a></li>
                        <li><a href="#">Artistas</a></li>
                        <li><a href="#">Solicitar</a></li>
                        <li><a href="#">Registro</a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mi cuenta <span class="caret"></span>
                          </a>
                          <ul id="mi-cuenta" class="dropdown-menu">
                            <li><a href="#">Ver mi perfil</a></li>
                            <li><a href="#">Bandeja de entrada</a></li>
                            <li><a href="#">Configuración</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Cerrar sesión</a></li>
                          </ul>
                        </li>
                    </ul>

                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Artista, disco, canción..." style="border-radius: 30px; width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="border-radius: 30px;">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </form>

                    <ul class="nav navbar-nav navbar-right searcher">
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-search"></span></a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</header>