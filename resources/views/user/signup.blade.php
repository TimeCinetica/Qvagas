<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/user/signup.js'],
'css' => ['css/user/signup.css'],
'forceAdsense' => true
])

<body id="signup-page">
    @include('shared.nav', ['hideOptions' => true])
    <div class="container">
        <div class="row">
            <h1>Cadastro de Currículo</h1>
        </div>
        <div class="row">
            <p class="important-row">
                <b>Olá Candidato da QVagas!</b>
            </p>
            <p>
                Neste espaço você realizará seu cadastro no nosso banco de dados,
                sendo este o primeiro contato. Por isso, preencha todos os campos da forma
                mais completa possível, principalmente os de contatos, pois será através desses
                dados que falaremos com você.
            </p>
            <p class="important-row">
                <b>IMPORTANTE:</b>
            </p>
            <p>
                1. No campo <b>"Qual cargo você deseja atuar, ou área de atuação"</b>
                você pode atualizar com seu login e senha (enviado por e-mail)
                conforme seu interesse pela vaga que surgir no nosso site ou quando mudar
                seu interesse de atuação profissional.
            </p>
            <p>
                2. Você não é obrigado a colocar dados que não se sinta seguro ou
                confortável de compartilhar. Neste caso, você pode colocar 0000
                (sequências de zeros) ou responder não sei. <b>Isso não irá interferir
                    no seu processo de análise.</b>
            </p>
            <p>
                Os campos com Asterisco(*) são obrigatórios
            </p>
        </div>
        <div class="row">
            <div class="accordion" id="signup-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Dados Pessoais <i id="icon-status-one" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            <form id="signup-personal" novalidate>
                                <div class="form-group">
                                    <label for="name">Nome completo *</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="Seu Nome Completo" required>
                                </div>
                                <div class="form-group">
                                    <label for="cpf" class="d-flex justify-content-between">CPF *
                                        <u data-bs-toggle="tooltip" data-bs-placement="top" title="O CPF é fundamental para garantir a autenticidade do seu cadastro no site, não disponibilizamos seu CPF ou dados para empresas.">
                                            Porque pedimos o CPF?
                                        </u>
                                    </label>
                                    <input name="cpf" id="cpf" type="tel" inputmode="tel" class="form-control" placeholder="000.000.000-00" required minlength="14" maxlength="14">
                                </div>
                                <div class="form-group">
                                    <label for="birth-date">Data de nascimento *</label>
                                    <input name="birthDate" id="birth-date" data-provide="datepicker" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cellphone">Telefone principal *</label>
                                    <input name="cellphone" id="cellphone" type="tel" inputmode="tel" class="form-control" placeholder="(27) 99999-9999" required minlength="14" maxlength="16">
                                </div>
                                <div class="form-group">
                                    <label for="cellphone-2">Telefone alternativo</label>
                                    <input name="cellphone2" id="cellphone-2" type="tel" inputmode="tel" class="form-control" placeholder="(27) 99999-9999" minlength="14" maxlength="16">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="d-flex justify-content-between">E-mail *
                                        <u data-bs-toggle="tooltip" data-bs-placement="top" title="Você vai receber no seu e-mail uma senha e um login para fazer ter acesso ao seu perfil.">
                                            Porque o e-mail é importante?
                                        </u>
                                    </label>
                                    <input name="email" id="email" type="email" inputmode="email" class="form-control" placeholder="seu@email.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="linkedin">Link do Linkedin</label>
                                    <input name="linkedin" id="linkedin" type="url" inputmode="url" class="form-control" placeholder="https://www.linkedin.com/in/seu-linkedin/">
                                </div>
                                <div class="form-group">
                                    <label for="lattes">Link do currículo lattes</label>
                                    <input name="lattes" id="lattes" type="url" inputmode="url" class="form-control" placeholder="https://www.seu-lattes.com.br">
                                </div>
                                <div class="form-group">
                                    <label for="video">Link vídeo currículo</label>
                                    <input name="video" id="video" type="url" inputmode="url" class="form-control" placeholder="https://www.youtube.com/watch?v=xxxxxx">
                                </div>
                                <div class="form-group">
                                    <label for="schooling" class="d-flex justify-content-between">Escolaridade (Formação Acadêmica) *
                                        <u data-bs-toggle="tooltip" data-bs-placement="top" title="Preencha de modo completo, caso tenha curso técnico ou superior ou especialidades especificar qual.">
                                            Como preencher?
                                        </u>
                                    </label>
                                    <input name="schooling" id="schooling" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cep">CEP *</label>
                                    <input name="cep" id="cep" type="tel" inputmode="tel" class="form-control" placeholder="12345-678" required minlength="9" maxlength="9">
                                </div>
                                <div class="form-group">
                                    <label for="address">Endereço *</label>
                                    <input name="address" id="address" type="text" class="form-control" placeholder="Rua Mario da Silva" required>
                                </div>
                                <div class="form-group">
                                    <label for="number">Número *</label>
                                    <input name="number" id="number" type="text" class="form-control" placeholder="123" required>
                                </div>
                                <div class="form-group">
                                    <label for="district">Bairro *</label>
                                    <input name="district" id="district" type="text" class="form-control" placeholder="Santo Agostinho" required>
                                </div>
                                <div class="form-group">
                                    <label for="stateId">Estado *</label>
                                    <select name="stateId" id="stateId" class="form-select" required>
                                        <option value="">Selecione uma opção</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cityId">Cidade *</label>
                                    <select name="cityId" id="cityId" class="form-select" required>
                                        <option value="">Selecione uma opção</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="sex">Sexo *</label>
                                            <select id="sex" name="sex" class="form-select">
                                                <option value="0" selected>Outro</option>
                                                <option value="1">Feminino</option>
                                                <option value="2">Masculino</option>
                                                <option value="3">Prefiro não responder</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="other-sex">Especifique *</label>
                                            <input id="other-sex" name="otherSex" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="rg">RG *</label>
                                            <input id="rg" name="rg" type="text" class="form-control" placeholder="1234000" required>
                                        </div>
                                        <div class="col">
                                            <label for="rg-state">Estado do RG *</label>
                                            <select name="rgStateId" id="rgStateId" class="form-select" required>
                                                <option value="">Selecione uma opção</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="father">Nome do pai</label>
                                    <input id="father" name="father" type="text" class="form-control" placeholder="João da Silva">
                                </div>
                                <div class="form-group">
                                    <label for="mother">Nome da mãe *</label>
                                    <input id="mother" name="mother" type="text" class="form-control" placeholder="Maria da Silva" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="civil">Estado Civil *</label>
                                            <select id="civil" name="civil" class="form-select">
                                                <option value="0" selected>Outro</option>
                                                <option value="1">Solteiro</option>
                                                <option value="2">Casado</option>
                                                <option value="3">Divorciado</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="other-civil">Especifique *</label>
                                            <input id="other-civil" name="otherCivil" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="raceId">Raça *</label>
                                    <select name="raceId" id="raceId" class="form-select" required>
                                        <option value="">Selecione uma opção</option>
                                        @foreach($races as $race)
                                        <option value="{{$race->id}}">{{$race->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="goToPersonalHistory()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Histórico Pessoal/Familiar <i id="icon-status-two" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            <form id="signup-history-personal" novalidate>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="volunteer-work">Você realiza trabalho voluntário?</label>
                                            <select id="volunteer-work" name="volunteerWork" class="form-select">
                                                <option value="1" selected>Sim</option>
                                                <option value="2">Não</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="other-volunteer-work">Qual? *</label>
                                            <input type="text" id="other-volunteer-work" name="otherVolunteerWork" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="has-children">Você tem filho(a,s)?</label>
                                            <select id="has-children" name="hasChildren" class="form-select">
                                                <option value="0" selected>Outro</option>
                                                <option value="1">Não</option>
                                                <option value="2">Sim</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="other-has-children">Especifique *</label>
                                            <input type="text" id="other-has-children" name="otherHasChildren" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="who-helps">Quem te ajuda quando você está desempregado?</label>
                                    <input type="text" id="who-helps" name="whoHelps" class="form-control" placeholder="Fulano da Silva">
                                </div>
                                <div class="form-group">
                                    <label for="accident">Se já sofreu algum acidente - Qual?</label>
                                    <input type="text" id="accident" name="accident" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="smoke">Você fuma - Quanto tempo consegue ficar sem fumar?</label>
                                    <input type="text" id="smoke" name="smoke" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="time-availability">Qual sua disponibilidade de tempo para a empresa?</label>
                                    <input type="text" id="time-availability" name="timeAvailability" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="work-weekends">Já trabalhou sábados, domingos e feriados? Pode trabalhar nestes dias?</label>
                                    <input type="text" id="work-weekends" name="workWeekends" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="miss-work">Escreva dois motivos que faria você faltar ao trabalho</label>
                                    <input type="text" id="miss-work" id="missWork" class="form-control" placeholder="">
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="goToProfessionalGoals()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Objetivos Profissionais <i id="icon-status-three" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            <form id="signup-professional-goals" novalidate>
                                <div class="form-group">
                                    <label for="occupation-area" class="d-flex justify-content-between">Qual cargo você deseja atuar, ou área de atuação. Exemplo: Área Administrativa ou Técnico em Mecânica.*
                                        <u data-bs-toggle="tooltip" data-bs-placement="top" title="Este campo sinaliza para os recrutadores qual cargo ou área você está se candidatando.">
                                            Para que serve este campo?
                                        </u>
                                    </label>
                                    <select name="occupationArea" multiple id="occupation-area" class="form-select" required></select>
                                    @include('components.form.validation', ['invalidMessage' => "Pelo menos uma ocupação é obrigatória."])
                                </div>
                                <div class="form-group">
                                    <label for="type-of-vacancy">Tipo de vaga *</label>
                                    <select id="vacancy-type-id" name="vacancyTypeId" class="form-select" required>
                                        @foreach ($vacancyTypes as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="pcd-report-input">
                                    <label for="pcd-report">Laudo PCD *</label>
                                    <input id="pcd-report" type="file" class="form-control" onchange="handlePhoto('pcdReport', this.files)">
                                </div>
                                <div class="form-group">
                                    <label for="salary">Pretensão salarial</label>
                                    <input type="text" id="salary" name="salary" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="type-working">Tipo de Jornada de Trabalho *</label>
                                    <select id="type-working" name="typeWorking" class="form-select" required>
                                        <option value="1" selected>Integral</option>
                                        <option value="2">Home Office</option>
                                        <option value="3">Flexível</option>
                                        <option value="4">Meio Período (noturno, matutino ou vespertino)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type-contract">Tipo de contrato *</label>
                                    <select id="type-contract" name="typeContract" class="form-select" required>
                                        <option value="1" selected>CLT (Carteira Assinada)</option>
                                        <option value="2">PJ (Pessoa Jurídica)</option>
                                        <option value="3">Freelancer</option>
                                    </select>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="goToProfessionalHistory()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Histórico Profissional <i id="icon-status-four" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            <form id="professional-history" novalidate>
                                <div class="form-group">
                                    <label for="courses">Cursos ou participação de eventos</label>
                                    <textarea id="courses" name="courses" type="text" class="form-control" placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="first-job">Qual foi seu 1º emprego (mesmo sem carteira assinada)</label>
                                    <input id="first-job" name="firstJob" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="unemployed-time">Há quanto tempo está desempregado</label>
                                    <input id="unemployed-time" name="unemployedTime" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="labor-activity">Qual atividade laboral você desenvolve quando está desempregado</label>
                                    <input id="labor-activity" name="laborActivity" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="target-job">Se pudesse escolher, com o que gostaria de trabalhar. *</label>
                                    <input id="target-job" name="targetJob" type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="goToProfessionalExperience()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Experiência Profissional <i id="icon-status-five" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            Escreva suas experiências profissionais mais recentes, mesmo que não seja de carteira assinada.
                            <form id="professional-experience" novalidate>
                                <div id="company-buttons" class="form-group">
                                    <div class="d-flex justify-content-evenly">
                                        <a class=" btn btn-primary" onclick="addExpirence()">
                                            <i class="bi bi-plus-lg"></i> Adicionar experiência
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last-salary">Último salário</label>
                                    <input id="last-salary" name="lastSalary" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="abstract">Breve resumo sobre experiência profissional</label>
                                    <textarea id="abstract" name="abstract" type="text" class="form-control" placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="reference">Alguém daria referências profissional ? Quem e Telefone</label>
                                    <textarea id="reference" name="reference" type="text" class="form-control" placeholder=""></textarea>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="goToComplementaryData()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Dados Complementares <i id="icon-status-six" class="bi bi-exclamation-circle text-warning"></i>
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#signup-accordion">
                        <div class="accordion-body">
                            <form id="complementary-data" novalidate>
                                <div class="form-group">
                                    <label for="hobbies">Atividades extra curriculares (Hobbies)</label>
                                    <textarea id="hobbies" name="hobbies" type="text" class="form-control" placeholder=""></textarea>
                                </div>
                                <hr>
                                <div id="language-buttons" class="form-group">
                                    <div class="d-flex justify-content-evenly">
                                        <a class=" btn btn-primary" onclick="addLanguage()">
                                            <i class="bi bi-plus-lg"></i> Adicionar idioma
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="available-travel">Disponibilidade para viajar</label>
                                    <select id="available-travel" name="availableTravel" class="form-select">
                                        <option value="1" selected>Sim</option>
                                        <option value="2">Não</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="personal-photo">Upload Foto</label>
                                    <input id="personal-photo" type="file" class="form-control" onchange="handlePhoto('personalPhoto', this.files)">
                                </div>
                                <div class="form-group">
                                    <label for="curriculum-photo">Upload Currículo</label>
                                    <input id="curriculum-photo" type="file" class="form-control" onchange="handlePhoto('resumePhoto', this.files)">
                                </div>
                                <div class="form-group">
                                    <label for="recomendation-photo">Upload de Carta de Recomendação</label>
                                    <input id="recomendation-photo" type="file" class="form-control" onchange="handlePhoto('recomendationPhoto', this.files)">
                                </div>
                                <div class="form-group">
                                    <label for="password">Senha de acesso *</label>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="******" minlength="6" required>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Confirmar senha de acesso *</label>
                                    <input id="password-confirm" type="password" class="form-control" placeholder="******" minlength="6" required>
                                </div>
                                <div class="form-group">
                                    <label for="public-curriculum">Outras empresas além da Quallity Psi podem ter acesso a este seu currículo?</label>
                                    <select id="public-curriculum" name="publicCurriculum" class="form-select">
                                        <option value="1" selected>Sim</option>
                                        <option value="2">Não</option>
                                    </select>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <a class="btn btn-primary next-button" onclick="validateAll()">Ok</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form id="accept-terms-form" novalidate>
                <div class="form-check terms-input">
                    <input class="form-check-input" type="checkbox" id="accept-terms" required>
                    <label class="form-check-label" for="accept-terms">
                        Concordo com os <a href="https://quallitypsi.com.br/termos-e-condicoes-gerais-para-cadastramento-no-qvagas/" target="_blank" rel="noopener noreferrer">Termos e Condições Gerais para Cadastramento no QVagas</a> e
                        <a href="https://quallitypsi.com.br/politicas-de-privacidade-e-relacionamento-com-usuarios/" target="_blank" rel="noopener noreferrer">Políticas de Privacidade e Relacionamento com Usuários.</a>
                        Assumo total responsabilidade pelos dados acima, por mim, informados neste cadastro. *
                    </label>
                </div>
            </form>
        </div>
        <div class="row d-flex justify-content-center">
            <a id="signup-button" class="btn btn-primary d-flex align-items-center justify-content-center" onclick="signup()">Cadastrar Currículo Grátis</a>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>