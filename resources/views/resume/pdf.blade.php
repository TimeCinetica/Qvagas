<!DOCTYPE html>
<html>

<head>
    <title>{{$name}}</title>
    <style>
        @font-face {
            font-family: "Roboto";
            font-weight: normal;
            src: url('{{storage_path("/fonts/Roboto-Regular.TTF")}}') format("truetype");
        }

        @font-face {
            font-family: "RobotoBold";
            font-weight: bold;
            src: url('{{storage_path("/fonts/Roboto-Bold.TTF")}}') format("truetype");
        }

        body {
            font-family: "Roboto";
        }

        .row {
            display: flex;
            justify-content: center;
            text-align: center;
            height: 1.5rem;
        }

        .logo-row {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .logo-row img {
            height: 2.2rem;
            opacity: 0.5;
        }

        h1,
        h2 {
            background-color: #2698d4;
            color: white;
            font-family: "RobotoBold";
        }
    </style>
</head>

<body>
    <div class="logo-row">
        <img src="{{public_path('images/logo.png')}}" alt="logo">
    </div>
    <div class="row">
        <h1>CURRÍCULO</h1>
    </div>
    @if(auth()->user()->roleId < 3) <p>Data de preenchimento do cadastro: {{$createdAt}}</p>
        <p>Status do currículo: {{$resume['status']['name']}}</p>
        <p>
            Cargo desejado:
            @foreach($resume['occupations'] as $occupation)
            {{$occupation['name']}}
            @if(!$loop->last)
            ,
            @endif
            @endforeach
        </p>
        @endif

        <div class="row">
            <h2>DADOS PESSOAIS</h2>
        </div>
        <p>Nome: {{$name}}</p>
        <p>CPF: <label id="cpf">{{$cpf}}</label></p>
        <p>Data de nascimento: {{$birthDate}}</p>
        <p>Telefone principal: <label id="cellphone">{{$cellphone}}</label></p>
        <p>Telefone alternativo: <label id="cellphone2">{{$cellphone2}}</label></p>
        <p>E-mail: {{$email}}</p>
        <p>Linkedin: {{$resume['linkedin']}}</p>
        <p>Lattes: {{$resume['lattes']}}</p>
        <p>Vídeo currículo: {{$resume['video']}}</p>
        <p>Escolaridade: {{$schooling}}</p>
        <p>Endereço: {{$address}}, {{$number}}, {{$district}}. {{$city['name']}} - {{$state['abbr']}}</p>
        <p>Sexo: {{$sex}}</p>
        <p>RG: {{$rg}} - {{$rgState['abbr']}}</p>
        <p>Nome do pai: {{$father}}</p>
        <p>Nome da mãe: {{$mother}}</p>
        <p>Estado civil: {{$civil}}</p>
        <p>Raça: {{$race['name']}}</p>

        <div class="row">
            <h2>HISTÓRICO PESSOAL/FAMILIAR</h2>
        </div>
        <p>Realiza trabalho voluntário: {{$volunteerWork}}</p>
        <p>Tem filho(a,s): {{$hasChildren}}</p>
        <p>Quem ajuda quando está desempregado: {{$whoHelps}}</p>
        <p>Já sofreu algum acidente? Se sim, qual: {{$accident}}</p>
        <p>Você fuma - Quanto tempo consegue ficar sem fumar: {{$smoke}}</p>
        <p>Qual sua disponibilidade de tempo para a empresa: {{$timeAvailability}}</p>
        <p>Já trabalhou sábados, domingos e feriados? Pode trabalhar nestes dias? {{$workWeekends}}</p>
        <p>Escreva dois motivos que faria você faltar ao trabalho: {{$missWork}}</p>

        <div class="row">
            <h2>OBJETIVOS PROFISSIONAIS</h2>
        </div>
        <p>
            Cargo desejado:
            @foreach($resume['occupations'] as $occupation)
            {{$occupation['name']}}
            @if(!$loop->last)
            ,
            @endif
            @endforeach
        </p>
        <p>Tipo de vaga: {{$resume['vacancyType']['name']}}</p>
        <p>Pretensão salarial: {{$resume['salary']}}</p>
        <p>Tipo de vaga: {{$resume['typeWorking']}}</p>
        <p>Tipo de contrato: {{$resume['typeContract']}}</p>

        <div class="row">
            <h2>HISTÓRICO PROFISSIONAL</h2>
        </div>
        <p>Cursos ou participação de eventos: {{$resume['courses']}}</p>
        <p>Qual foi seu 1º emprego (mesmo sem carteira assinada): {{$resume['firstJob']}}</p>
        <p>Há quanto tempo está desempregado: {{$resume['unemployedTime']}}</p>
        <p>
            Qual atividade laboral você desenvolve quando está desempregado: {{$resume['laborActivity']}}</p>
        <p>Se pudesse escolher, com o que gostaria de trabalhar: {{$resume['targetJob']}}</p>

        <div class="row">
            <h2>EXPERIÊNCIA PROFISSIONAL</h2>
        </div>
        <p>
            @foreach($resume['companies'] as $companies)
        <p>Nome da empresa: {{$companies['companyName']}}</p>
        <p>Funções e atividades: {{$companies['companyActivity']}}</p>
        <p>Esse é o meu emprego atual: {{$companies['actualJob']}}</p>
        <p>Admitido: {{$companies['companyStart']}}</p>
        <p>Demitido: {{$companies['companyEnd']}}</p>
        <p>Motivo de saída: {{$companies['companyLeftReason']}}</p>
        <hr>
        @endforeach
        </p>
        <p>Último salário: {{$resume['lastSalary']}}</p>
        <p>Breve resume sobre experiência profissional: {{$resume['abstract']}}</p>
        <p>Alguém daria referências profissionais? Quem e telefone: {{$resume['reference']}}</p>

        <div class="row">
            <h2>DADOS COMPLEMENTARES</h2>
        </div>
        <p>Atividades extra curriculares (Hobbies): {{$hobbies}}</p>
        <p>
            @foreach($resume['languages'] as $language)
        <p>Idioma: {{$language['language']}}</p>
        <p>Nível: {{$language['level']}}</p>
        <hr>
        @endforeach
        </p>
        <p>Disponibilidade para viajar: {{$availableTravel}}</p>
</body>

</html>