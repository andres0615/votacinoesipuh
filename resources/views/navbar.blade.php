<nav class="navbar navbar-custom" role="navigation">
    <div class="container-fluid">
        <!-- El logotipo y el icono que despliega el menú se agrupan
             para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                <span class="sr-only">Desplegar navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Agrupar los enlaces de navegación, los formularios y cualquier
             otro elemento que se pueda ocultar al minimizar la barra -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            {{--<ul class="nav navbar-nav">
                <li class="active"><a href="{{ route('inicio') }}">Inicio</a></li>
                <li><a href="#">Ingresar</a></li>
                <li><a href="#">Registrarse</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                        Publicaciones <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Oportunidad de negocio</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Bienestar y salud</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Ver todas</a></li>
                    </ul>
                </li>
                <li><a href="#">Capacitaciones</a></li>
            </ul>--}}
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                        Perfil <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('profile') }}">Mi cuenta</a></li>
                        <li class="divider" ></li>
                        <li><a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();" >Salir</a>
                         </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
