<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    @guest
        <a class="navbar-brand" href="{{ url('/') }}">
            Anglo Líderes
        </a>
    @else
        <a class="navbar-brand" href="{{ url('/home') }}">
            Anglo Líderes
        </a>
    @endguest
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div style="width: 100%">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link " href="{{ route('login') }}">{{ __('Faça o login') }}</a></li>
                    <!-- <li><a class="nav-link" href="{{ route('register') }}">{{ __('Cadastre-se') }}</a></li> -->
                @else
                    
                    <li><span class="nav-link font-weight-bold">{{ Auth::user()->name }}</span></li>
                    
                    @role('Aluno')
                    <li><a class="nav-link" href="{{ route('home') }}">Acessar Curso</a></li>
                    @endrole
                    @role('Admin|Gestor')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administração
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @role('Gestor')
                            <a class="dropdown-item" href="{{ route('matriculas.index') }}">Matrículas</a>
                            @endrole
                            @role('Admin')
                            <a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small"><strong>Clientes</strong></a>
                            <a class="dropdown-item" href="{{ route('planos.index') }}">Planos</a> 
                            <a class="dropdown-item" href="{{ route('empresas.index') }}">Empresas</a>                                    
                            <a class="dropdown-item" href="{{ route('matriculas.index') }}">Matrículas</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small"><strong>Conteúdo</strong></a>
                            <a class="dropdown-item" href="{{ route('modulos.index') }}">Módulos</a>
                            <a class="dropdown-item" href="{{ route('aulas.index') }}">Aulas</a>
                            <a class="dropdown-item" href="{{ route('materiais.index') }}">Materiais</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small"><strong>Feedbacks</strong></a>
                            <a class="dropdown-item" href="{{ route('questionarios.index') }}">Questionários</a>
                            <a class="dropdown-item" href="{{ route('perguntas.index') }}">Perguntas</a>
                            <a class="dropdown-item" href="{{ route('respostas.index') }}">Respostas</a>
                            <a class="dropdown-item" href="{{ route('feedbacks.index') }}">Visualizar feedbacks</a>
                            @endrole
                        </div>
                    </li>
                    @endrole

                    <li><a class="nav-link" href="{{ route('userslogged.index') }}">Meus dados</a></li>
                    <li><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Sair</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>


                @endguest
            </ul>
        </div>
        @if (Request::path() == 'quizzes/responder' && isset($quizz))
            <h4 class="pt-4 text-right">{!! $quizz->nome !!}</h4>
        @endif
    </div>
</nav>