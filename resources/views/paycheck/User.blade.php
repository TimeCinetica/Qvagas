<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/list.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css']
])

<body id="paycheck-collaborator-page">
    @include('shared.nav')
    <div class="container">
    <div class="col">
            <div class="row">
                <div class="header">
                    <h2>Contracheques - {{$user->name}}</h2>
                </div>
            </div>
            <table id="list-paychecks-table" class="table table-striped fast-table">
                <thead>
                    <tr><th class="text-center cpf-col"></th>
                        <th class="text-center">Enviado por</th>
                        <th class="text-center">Criado em</th>
                        <th class="text-center">Contracheques</th>
                        <th class="text-center">Status</th>               
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paycheckes as $paycheck)
                    <tr>
                        <td>{{$paycheck->nomeAdmin}}</td>
                        <td>{{$paycheck->created_at}}</td>
                        <td>{{$paycheck->paycheckpdf}}</td>
                        <td>não</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

    <br>
    </div>
</body>
</html>