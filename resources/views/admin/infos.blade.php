<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/admin/infos.js'],
'css' => ['css/admin/infos.css', 'css/components/card/enumerable.css']
])

<body id="info-page">
    @include('shared.nav')
    <div class="container">
        <div class="row">
            <h1 class="welcome">Estatísticas</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Avaliação da Equipe do QVagas', 'value' => $evaluated, 'color' => 'green'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Selo de Talentos do LabCarrerias', 'value' => $stamped, 'color' => 'blue'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Total de Currículos Cadastrados', 'value' => $total, 'color' => 'yellow'])
            </div>
            <div class="col">
                @include('components.card.enumerable', ['title' => 'Currículos não atualizados há 6 meses', 'value' => $deprecated, 'color' => 'red'])
            </div>
        </div>
        <div id="graphs" class="row">
            <div class="row" style="height: 25em;">
                <div class="col-3">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Sexo</h4>
                            <canvas id="sexChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Profissões mais cadastradas</h4>
                            <table class="graph-table" id="occupations-table">
                                <tr>
                                    <th class="id">#</th>
                                    <th>Profissões</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Etnia</h4>
                            <canvas id="raceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Jornada de Trabalho</h4>
                            <canvas id="typeWorkingChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Tipo de Contrato</h4>
                            <canvas id="typeContractChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Tipo de Vaga</h4>
                            <canvas id="vacancyTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 25em;">
                <div class="col-8">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Currículos por Status</h4>
                            <canvas id="resumeStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <h4 class="card-title">Currículos por Cidade</h4>
                            <table class="graph-table" id="cities-table">
                                <tr>
                                    <th class="id">Cidade</th>
                                    <th class="right">Quantidade</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>