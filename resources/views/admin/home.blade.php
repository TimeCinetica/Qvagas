<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/admin/home.js'],
'css' => ['css/admin/home.css', 'css/components/card/enumerable.css']
])

<body id="home-page">
    @include('shared.nav')
    <div class="container">
        <div class="row">
            <h1 class="welcome">Seja bem vindo(a)!</h1>
        </div>
        <div class="row subtitle">
            <h4>Resumo</h4>
        </div>
        <div class="row">
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Avaliação da Equipe do QVagas', 'value' => $evaluated, 'color' => 'green', 'redirectTo' => 'resumes?page=1&evaluated=1'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Selo de Talentos do LabCarrerias', 'value' => $stamped, 'color' => 'blue', 'redirectTo' => 'resumes?page=1&stamped=1'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Total de Currículos Cadastrados', 'value' => $total, 'color' => 'yellow'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Currículos não atualizados há 6 meses', 'value' => $deprecated, 'color' => 'red', 'redirectTo' => 'resumes?page=1&deprecated=1'])
            </div>
        </div>
        <div class="see-more subtitle">
            <h4>Currículos por Status</h4>
            <a id="toggle-btn" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick=toggleCards()>
                <i class="bi bi-plus"></i>
                <p>Ver mais</p>
            </a>
        </div>
        <div class="row">
            <div class="accordion" id="home-accordion">
                <div class="accordion-item">
                    <div class="row accordion-header" id="heading">
                        <div class="col">
                            @include('components.card.enumerable', ['id' => 'status1', 'title' => 'Não avalidados', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=1'])
                        </div>
                        <div class="col">
                            @include('components.card.enumerable', ['id' => 'status2', 'title' => 'Não qualificados', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=2'])
                        </div>
                        <div class="col">
                            @include('components.card.enumerable', ['id' => 'status3', 'title' => 'Qualificados', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=3'])
                        </div>
                        <div class="col">
                            @include('components.card.enumerable', ['id' => 'status4', 'title' => 'Contratados', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=4'])
                        </div>
                    </div>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status5', 'title' => 'Banco de dados', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=5'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status6', 'title' => 'Stand By', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=6'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status7', 'title' => 'Alinhamento com a vaga', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=7'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status8', 'title' => 'Espera do contrato do contratante', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=8'])
                                </div>
                            </div>
                        </div>
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status9', 'title' => 'Testes e Questionário', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=9'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status10', 'title' => 'Sem candidatura', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=10'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status11', 'title' => 'Entrevista com o contratante', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=11'])
                                </div>
                                <div class="col">
                                    @include('components.card.enumerable', ['id' => 'status12', 'title' => 'Entrevista com Recrutador', 'value' => '0', 'redirectTo' => 'resumes?page=1&status=12'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="card-options" class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
            <div class="col">
                <div class="card card-shadow" onclick="redirect('occupations')">
                    <div class=" card-body">
                        <div class="option">
                            <i class="bi bi-person-lines-fill"></i>
                            <label>Gestão de Profissões</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-shadow" onclick="redirect('resumes')">
                    <div class=" card-body">
                        <div class="option">
                            <i class="bi bi-search"></i>
                            <label>Busca Por Candidato</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-shadow" onclick="redirect('infos')">
                    <div class=" card-body">
                        <div class="option">
                            <i class="bi bi-question-circle"></i>
                            <label>Perfis dos Canditatos</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-shadow" onclick="redirect('contracheque')">
                    <div class=" card-body">
                        <div class="option">
                            <i class="bi bi-clipboard"></i>
                            <label>QContracheque</label>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->isSadmin())
            <div class="col">
                <div class="card card-shadow" onclick="redirect('admins')">
                    <div class=" card-body">
                        <div class="option">
                            <i class="bi bi-person-lines-fill"></i>
                            <label>Gestão de Usuários</label>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col">
                <div class="card card-shadow" onclick="redirect('admin/change-password')">
                    <div class="card-body">
                        <div class="option">
                            <i class="bi bi-lock"></i>
                            <label>Alterar senha</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>