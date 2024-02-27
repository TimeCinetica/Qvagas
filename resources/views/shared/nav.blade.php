<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/shared/navbar.css') }}">
    </link>
    <script src="{{ asset('js/shared/navbar.js') }}"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{asset('images/logo.png')}}" alt="logo"></a>
        @if(auth()->check() && auth()->user()->isAdmin())
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/contracheque">Contracheques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/occupations">Gestão de profissões</a>
                </li>
                @if(auth()->user()->isSadmin())
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/resumes">Busca por candidato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/admins">Gestão de usuários</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/infos">Perfil dos candidatos</a>
                </li>
                <li class="nav-item logout-position">
                    <a class="nav-link" onclick="logout()">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair
                    </a>
                </li>
            </ul>
        </div>
        @elseif((!isset($hideOptions) || !$hideOptions) && auth()->check())
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @if(auth()->user()->roleId != 4)
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" onclick="goToResume({{auth()->user()->id}})">Meu Currículo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://qvagas.quallitypsi.com.br/index.php/anuncios/">Busca Por Vaga</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://qvagas.quallitypsi.com.br/index.php/ajuda/">Ajuda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://quallitypsi.com.br/blog/">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://qvagas.quallitypsi.com.br/index.php/dica-qvagas/">Dicas QVagas</a>
                </li>
                <li class="nav-item logout-position">
                    <a class="nav-link" onclick="logout()">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair
                    </a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>