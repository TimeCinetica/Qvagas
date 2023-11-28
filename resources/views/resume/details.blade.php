<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/resume/details.js'],
'css' => ['css/resume/details.css']
])

<body id="details-page" onload='onInit(@json($user))'>
    @include('shared.nav')
    <div class="container">
        <div id="page-header" class="d-flex justify-content-between align-items-end">
            @if($roleId == 3)
            <h1>Meu Currículo</h1>
            @else
            <h1>Currículo - {{$user['name']}}</h1>
            @endif
            <div>
                @if($roleId == 1 || $roleId == 3)
                <a id="edit-shortcut" class="btn btn-primary top-buttons" onclick="edit()">Editar currículo <i class="bi bi-pencil-square"></i></a>
                @endif
                <a class="btn btn-outline-primary top-buttons" href="{{URL::to($user['id'] . '/resume/pdf')}}">Exportar currículo <i class="bi bi-download"></i></a>
            </div>
        </div>
        @if($roleId < 3) <div class="row">
            @include('components.resume.performance', ['user' => $performance, 'roleId' => $roleId])
    </div>
    @endif
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
                                <input name="name" id="name" type="text" class="form-control" placeholder="Seu Nome Completo" value="{{$user['name']}}" disabled required>
                            </div>
                            <div class="form-group">
                                <label for="cpf" class="d-flex justify-content-between">CPF *
                                    <u data-bs-toggle="tooltip" data-bs-placement="top" title="O CPF é fundamental para garantir a autenticidade do seu cadastro no site, não disponibilizamos seu CPF ou dados para empresas.">
                                        Porque pedimos o CPF?
                                    </u>
                                </label>
                                <input name="cpf" id="cpf" type="tel" inputmode="tel" class="form-control" placeholder="000.000.000-00" required minlength="14" maxlength="14" value="{{$user['cpf']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="birth-date">Data de nascimento *</label>
                                <input name="birthDate" id="birth-date" data-provide="datepicker" type="text" class="form-control" required value="{{$user['birthDate']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="cellphone">Telefone principal *</label>
                                <input name="cellphone" id="cellphone" type="tel" inputmode="tel" class="form-control" placeholder="(27) 99999-9999" required minlength="14" maxlength="16" value="{{$user['cellphone']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="cellphone-2">Telefone alternativo</label>
                                <input name="cellphone2" id="cellphone-2" type="tel" inputmode="tel" class="form-control" placeholder="(27) 99999-9999" minlength="14" maxlength="16" value="{{$user['cellphone2']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email" class="d-flex justify-content-between">E-mail *
                                    <u data-bs-toggle="tooltip" data-bs-placement="top" title="Você vai receber no seu e-mail uma senha e um login para fazer ter acesso ao seu perfil.">
                                        Porque o e-mail é importante?
                                    </u>
                                </label>
                                <input name="email" id="email" type="email" inputmode="email" class="form-control" placeholder="seu@email.com" required value="{{$user['email']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="linkedin">Link do Linkedin</label>
                                <input name="linkedin" id="linkedin" type="url" inputmode="url" class="form-control" placeholder="https://www.linkedin.com/in/seu-linkedin/" value="{{$user['resume']['linkedin']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="lattes">Link do currículo lattes</label>
                                <input name="lattes" id="lattes" type="url" inputmode="url" class="form-control" placeholder="https://www.seu-lattes.com.br" value="{{$user['resume']['lattes']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="video">Link vídeo currículo</label>
                                <input name="video" id="video" type="url" inputmode="url" class="form-control" placeholder="https://www.youtube.com/watch?v=xxxxxx" value="{{$user['resume']['video']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="schooling" class="d-flex justify-content-between">Escolaridade (Formação Acadêmica) *
                                    <u data-bs-toggle="tooltip" data-bs-placement="top" title="Preencha de modo completo, caso tenha curso técnico ou superior ou especialidades especificar qual.">
                                        Como preencher?
                                    </u>
                                </label>
                                <input name="schooling" id="schooling" type="text" class="form-control" required value="{{$user['schooling']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="cep">CEP *</label>
                                <input name="cep" id="cep" type="tel" inputmode="tel" class="form-control" placeholder="12345-678" required minlength="9" maxlength="9" value="{{$user['cep']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="address">Endereço *</label>
                                <input name="address" id="address" type="text" class="form-control" placeholder="Rua Mario da Silva" required value="{{$user['address']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="number">Número *</label>
                                <input name="number" id="number" type="text" class="form-control" placeholder="123" required value="{{$user['number']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="district">Bairro *</label>
                                <input name="district" id="district" type="text" class="form-control" placeholder="Santo Agostinho" required value="{{$user['district']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="state">Estado *</label>
                                <select name="stateId" id="stateId" class="form-select" required disabled>
                                    <option value="{{$user['state']['id']}}">{{$user['state']['name']}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cityId">Cidade *</label>
                                <select name="cityId" id="cityId" class="form-select" required disabled>
                                    <option value="{{$user['city']['id']}}">{{$user['city']['name']}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="sex">Sexo *</label>
                                        <select id="sex" name="sex" class="form-select" disabled>
                                            <option value="0" {{$user['sex'] == '0' ? 'selected' : ''}}>Outro</option>
                                            <option value="1" {{$user['sex'] == '1' ? 'selected' : ''}}>Feminino</option>
                                            <option value="2" {{$user['sex'] == '2' ? 'selected' : ''}}>Masculino</option>
                                            <option value="3" {{$user['sex'] == '3' ? 'selected' : ''}}>Prefiro não responder</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="other-sex">Especifique *</label>
                                        <input id="other-sex" name="otherSex" type="text" class="form-control" required value="{{$user['otherSex']}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="rg">RG *</label>
                                        <input id="rg" name="rg" type="text" class="form-control" placeholder="1234000" required value="{{$user['rg']}}" disabled>
                                    </div>
                                    <div class="col">
                                        <label for="rgStateId">Estado do RG *</label>
                                        <select name="rgStateId" id="rgStateId" class="form-select" required disabled>
                                            <option value="{{$user['rgState']['id']}}">{{$user['rgState']['abbr']}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="father">Nome do pai</label>
                                <input id="father" name="father" type="text" class="form-control" placeholder="João da Silva" value="{{$user['father']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="mother">Nome da mãe *</label>
                                <input id="mother" name="mother" type="text" class="form-control" placeholder="Maria da Silva" required value="{{$user['mother']}}" disabled>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="civil">Estado Civil *</label>
                                        <select id="civil" name="civil" class="form-select" disabled>
                                            <option value="0" {{$user['civil'] == '0' ? 'selected' : ''}}>Outro</option>
                                            <option value="1" {{$user['civil'] == '1' ? 'selected' : ''}}>Solteiro</option>
                                            <option value="2" {{$user['civil'] == '2' ? 'selected' : ''}}>Casado</option>
                                            <option value="3" {{$user['civil'] == '3' ? 'selected' : ''}}>Divorciado</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="other-civil">Especifique *</label>
                                        <input id="other-civil" name="otherCivil" type="text" class="form-control" required value="{{$user['otherCivil']}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="raceId">Raça *</label>
                                <select name="raceId" id="raceId" class="form-select" required disabled>
                                    <option value="">Selecione uma opção</option>
                                    @foreach($races as $race)
                                    <option value="{{$race->id}}" {{$user['raceId'] == $race->id ? 'selected' : ''}}>{{$race->name}}</option>
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
                                        <select id="volunteer-work" name="volunteerWork" class="form-select" disabled>
                                            <option value="1" {{$user['volunteerWork'] == '1' ? 'selected' : ''}}>Sim</option>
                                            <option value="2" {{$user['volunteerWork'] == '2' ? 'selected' : ''}}>Não</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="other-volunteer-work">Qual? *</label>
                                        <input type="text" id="other-volunteer-work" name="otherVolunteerWork" class="form-control" required value="{{$user['otherVolunteerWork']}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="has-children">Você tem filho(a,s)?</label>
                                        <select id="has-children" name="hasChildren" class="form-select" disabled>
                                            <option value="0" {{$user['hasChildren'] == '0' ? 'selected' : ''}}>Outro</option>
                                            <option value="1" {{$user['hasChildren'] == '1' ? 'selected' : ''}}>Não</option>
                                            <option value="2" {{$user['hasChildren'] == '2' ? 'selected' : ''}}>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="other-has-children">Especifique *</label>
                                        <input type="text" id="other-has-children" name="otherHasChildren" class="form-control" required value="{{$user['otherHasChildren']}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="who-helps">Quem te ajuda quando você está desempregado?</label>
                                <input type="text" id="who-helps" name="whoHelps" class="form-control" placeholder="Fulano da Silva" value="{{$user['whoHelps']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="accident">Se já sofreu algum acidente - Qual?</label>
                                <input type="text" id="accident" name="accident" class="form-control" placeholder="" value="{{$user['accident']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="smoke">Você fuma - Quanto tempo consegue ficar sem fumar?</label>
                                <input type="text" id="smoke" name="smoke" class="form-control" placeholder="" value="{{$user['smoke']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="time-availability">Qual sua disponibilidade de tempo para a empresa?</label>
                                <input type="text" id="time-availability" name="timeAvailability" class="form-control" placeholder="" value="{{$user['timeAvailability']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="work-weekends">Já trabalhou sábados, domingos e feriados? Pode trabalhar nestes dias?</label>
                                <input type="text" id="work-weekends" name="workWeekends" class="form-control" placeholder="" value="{{$user['workWeekends']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="miss-work">Escreva dois motivos que faria você faltar ao trabalho</label>
                                <input type="text" id="miss-work" id="missWork" class="form-control" placeholder="" value="{{$user['missWork']}}" disabled>
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
                                <select name="occupationArea" multiple id="occupation-area" class="form-select" required disabled></select>
                                @include('components.form.validation', ['invalidMessage' => "Pelo menos uma ocupação é obrigatória."])
                            </div>
                            <div class="form-group">
                                <label for="type-of-vacancy">Tipo de vaga *</label>
                                <select id="vacancy-type-id" name="vacancyTypeId" class="form-select" required disabled>
                                    @foreach ($vacancyTypes as $type)
                                    <option value="{{$type->id}}" {{$user['resume']['vacancyTypeId'] == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(isset($user['pcdReport']))
                            <div class="form-group">
                                <label>Laudo PCD *</label>
                                <div class="row">
                                    <a target="_blank" class="view-file" href="{{$user['pcdReport']}}"><i class="bi bi-file-medical-fill"></i> Laudo PCD</a>
                                </div>
                            </div>
                            @endif
                            <div class="form-group" id="pcd-report-input">
                                <label for="pcd-report">Laudo PCD *</label>
                                <input id="pcd-report" type="file" class="form-control" onchange="handlePhoto('pcdReport', this.files)">
                            </div>
                            <div class="form-group">
                                <label for="salary">Pretensão salarial</label>
                                <input type="text" id="salary" name="salary" class="form-control" placeholder="" value="{{$user['resume']['salary']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="type-working">Tipo de Jornada de Trabalho *</label>
                                <select id="type-working" name="typeWorking" class="form-select" required disabled>
                                    <option value="1" {{$user['resume']['typeWorking'] == '1' ? 'selected' : ''}}>Integral</option>
                                    <option value="2" {{$user['resume']['typeWorking'] == '2' ? 'selected' : ''}}>Home Office</option>
                                    <option value="3" {{$user['resume']['typeWorking'] == '3' ? 'selected' : ''}}>Flexível</option>
                                    <option value="4" {{$user['resume']['typeWorking'] == '4' ? 'selected' : ''}}>Meio Período (noturno, matutino ou vespertino)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type-contract">Tipo de contrato *</label>
                                <select id="type-contract" name="typeContract" class="form-select" required disabled>
                                    <option value="1" {{$user['resume']['typeContract'] == '1' ? 'selected' : ''}}>CLT (Carteira Assinada)</option>
                                    <option value="2" {{$user['resume']['typeContract'] == '2' ? 'selected' : ''}}>PJ (Pessoa Jurídica)</option>
                                    <option value="3" {{$user['resume']['typeContract'] == '3' ? 'selected' : ''}}>Freelancer</option>
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
                                <textarea id="courses" name="courses" type="text" class="form-control" placeholder="" disabled>{{$user['resume']['courses']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="first-job">Qual foi seu 1º emprego (mesmo sem carteira assinada)</label>
                                <input id="first-job" name="firstJob" type="text" class="form-control" placeholder="" value="{{$user['resume']['firstJob']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="unemployed-time">Há quanto tempo está desempregado</label>
                                <input id="unemployed-time" name="unemployedTime" type="text" class="form-control" placeholder="" value="{{$user['resume']['unemployedTime']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="labor-activity">Qual atividade laboral você desenvolve quando está desempregado</label>
                                <input id="labor-activity" name="laborActivity" type="text" class="form-control" placeholder="" value="{{$user['resume']['laborActivity']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="target-job">Se pudesse escolher, com o que gostaria de trabalhar. *</label>
                                <input id="target-job" name="targetJob" type="text" class="form-control" placeholder="" required value="{{$user['resume']['targetJob']}}" disabled>
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
                                <div id="add-expirence-button">
                                    <a class=" btn btn-primary" onclick="addExpirence(null, false)">
                                        <i class="bi bi-plus-lg"></i> Adicionar experiência
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last-salary">Último salário</label>
                                <input id="last-salary" name="lastSalary" type="text" class="form-control" placeholder="" value="{{$user['resume']['lastSalary']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="abstract">Breve resumo sobre experiência profissional</label>
                                <textarea id="abstract" name="abstract" type="text" class="form-control" placeholder="" disabled>{{$user['resume']['abstract']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="reference">Alguém daria referências profissional ? Quem e Telefone</label>
                                <textarea id="reference" name="reference" type="text" class="form-control" placeholder="" disabled>{{$user['resume']['reference']}}</textarea>
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
                                <textarea id="hobbies" name="hobbies" type="text" class="form-control" placeholder="" disabled>{{$user['hobbies']}}</textarea>
                            </div>
                            <hr>
                            <div id="language-buttons" class="form-group">
                                <div id="add-language-button">
                                    <a class=" btn btn-primary" onclick="addLanguage(null, false)">
                                        <i class="bi bi-plus-lg"></i> Adicionar idioma
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="available-travel">Disponibilidade para viajar</label>
                                <select id="available-travel" name="availableTravel" class="form-select" disabled>
                                    <option value="1" {{$user['availableTravel'] == '1' ? 'selected' : ''}}>Sim</option>
                                    <option value="2" {{$user['availableTravel'] == '2' ? 'selected' : ''}}>Não</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="personal-photo-label" for="personal-photo">Upload Foto</label>
                                <div class="row" id="personal-photo">
                                    @if(isset($user['photo']))
                                    <a target="_blank" class="view-file" href="{{$user['photo']}}"><i class="bi bi-person-badge-fill"></i> Foto</a>
                                    @else
                                    <p><i>Nenhuma foto</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="curriculum-photo-label" for="curriculum-photo">Upload Currículo</label>
                                <div class="row" id="curriculum-photo">
                                    @if(isset($user['resume']['resumePhoto']))
                                    <a target="_blank" class="view-file" href="{{$user['resume']['resumePhoto']}}"><i class="bi bi-file-earmark-person-fill"></i> Currículo</a>
                                    @else
                                    <p><i>Nenhum currículo</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="recomendation-photo-label" for="recomendation-photo">Upload de Carta de Recomendação</label>
                                <div class="row" id="recomendation-photo">
                                    @if(isset($user['resume']['recomendationPhoto']))
                                    <a target="_blank" class="view-file" href="{{$user['resume']['recomendationPhoto']}}"><i class="bi bi-envelope-open-fill"></i> Carta de Recomendação</a>
                                    @else
                                    <p><i>Nenhuma carta de recomendação</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="public-curriculum">Outras empresas além da Quallity Psi podem ter acesso a este seu currículo?</label>
                                <select id="public-curriculum" name="publicCurriculum" class="form-select" disabled>
                                    <option value="1" {{$user['resume']['publicCurriculum'] == '1' ? 'selected' : ''}}>Sim</option>
                                    <option value="2" {{$user['resume']['publicCurriculum'] == '2' ? 'selected' : ''}}>Não</option>
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
    @if($roleId == 1 || $roleId == 3)
    <div id="edit-buttons" class="row">
        <a id="edit-button" class="btn btn-primary end-button d-flex align-items-center justify-content-center" onclick="edit()">Editar currículo</a>
    </div>
    <div id="save-buttons" class="row">
        <a id="revert-button" class="btn end-button d-flex align-items-center justify-content-center" onclick="revert({{$user['id']}})">Reverter alterações</a>
        <a id="save-button" class="btn btn-primary end-button d-flex align-items-center justify-content-center" onclick="save()">Salvar alterações</a>
    </div>
    @endif
    </div>

    @include('components.toast.default-toast')
</body>

</html>