<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/user/home.js'],
'css' => ['css/user/home.css']
])

<body id="home-page">
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="row justify-content-center welcome">
                <div class="card card-shadow">
                    <div class="card-body">
                        <h2 class="card-title">Seja Bem Vindo(a)!</h2>
                        <div class="card-text">
                            <p>
                                Se você está aqui é porque preencheu seu cadastro de currículo no nosso site QVagas.
                            </p>
                            <p>
                                Você encontrará uma diversidade de oportunidades de emprego, assuntos sobre desenvolvimento pessoal e profissional e outros.
                            </p>
                            <p>
                                Nós temos um compromisso com seus dados, então somente a equipe da Quallity Psi tem acesso e,
                                quando você ingressar em um processo seletivo, a empresa contratante terá acesso a suas experiências profissionais e dados pessoais de contato.
                            </p>
                            <p>
                                Abraços<br>
                                Equipe QVagas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="my-resume">
                <h4>
                    <b>Meu Desempenho</b>
                </h4>
                @if($roleId <= 3)
                    @include('components.resume.performance', ['user' => $user, 'roleId' => $roleId])
                @endif
            </div>
            <div id="card-options" class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                <div class="col">
                    <div class="card card-shadow" onclick="goToResume({{$user['id']}})">
                        <div class="card-body">
                            <div class="option">
                                <i class="bi bi-person-lines-fill"></i>
                                <label>Meu currículo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a href="https://qvagas.quallitypsi.com.br/index.php/anuncios/" target="_blank">
                        <div class="card card-shadow">
                            <div class="card-body">
                                <div class="option">
                                    <i class="bi bi-search"></i>
                                    <label>Busca Por Vaga</label>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://quallitypsi.com.br/blog/" target="_blank">
                        <div class="card card-shadow">
                            <div class="card-body">
                                <div class="option">
                                    <i class="bi bi-chat-left-quote"></i>
                                    <label>Blog</label>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://qvagas.quallitypsi.com.br/index.php/ajuda/" target="_blank">
                        <div class="card card-shadow">
                            <div class="card-body">
                                <div class="option">
                                    <i class="bi bi-question-circle"></i>
                                    <label>Ajuda</label>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <div class="card card-shadow" onclick="redirect('delete')">
                        <div class="card-body">
                            <div class="option">
                                <i class="bi bi-person-x-fill"></i>
                                <label>Excluir Cadastro</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a href="https://qvagas.quallitypsi.com.br/index.php/dica-qvagas/" target="_blank">
                        <div class="card card-shadow">
                            <div class="card-body">
                                <div class="option">
                                    <i class="bi bi-lightbulb"></i>
                                    <label>Dicas QVagas</label>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <div class="card card-shadow" onclick="redirect('user/change-password')">
                        <div class="card-body">
                            <div class="option">
                                <i class="bi bi-lock"></i>
                                <label>Alterar Senha</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.micromodal.default', ['id' => 1, 'title' => $user['resumeStatus']['name'], 'text' => $user['resumeStatus']['description']])
    @include('components.micromodal.default', ['id' => 2, 'title' => 'Avaliação da Equipe QVagas', 'text' => 'Nossa equipe realizará uma avaliação do seu currículo em nosso site e no seu currículo impresso/pdf.'])
    @include('components.micromodal.default', ['id' => 3, 'title' => 'Selo de Talento LabCarreiras', 'text' => 'O Selo é garantia ao contratante que você é um profissional que passou por uma mentoria de carreirae é uma indicação de excelênca da plataforma LabCarreiras e QVagas.'])
</body>

</html>