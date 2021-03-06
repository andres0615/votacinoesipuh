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

            <h4 style="color: #fff !important; text-shadow: 0 1px 2px #278838, 0 1px 0 #278838; font-family: 'Arimo', sans-serif; margin-left: .5em;" >{{ Auth::guard('persona')->user()->persona_nombre . ' ' . Auth::guard('persona')->user()->persona_apellido }}</h4>
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
                        @if(Auth::guard('persona')->user()->tipo_persona_id != 6 || (Auth::guard('persona')->user()->tipo_persona_id == 6 && session()->exists('menu') && session()->get('menu') != 'auxiliar'))
                        <li><a href="{{ route('inicio') }}">Mi cuenta</a></li>
                        <li class="divider" ></li>
                        @endif
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
