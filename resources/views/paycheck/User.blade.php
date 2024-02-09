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
                    <tr>
                        <th class="text-center">Enviado por</th>
                        <th class="text-center">Atualizado em</th>
                        <th class="text-center">Contracheques</th>             
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paycheckes as $paycheck)
                    <tr>
                        <td class="text-center">{{$user->admin_responsed}}</td>
                        <td class="text-center">{{$paycheck->updated_at}}</td>
                        <td class=>
                            <center>
                                <a class=" btn btn-primary btn-dft" href="{{ Storage::url($paycheck->paycheckpdf)}}">{{ \Carbon\Carbon::parse($paycheck->updated_at)->format('F/Y') }}</a>
                            </center>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

    <br>
    </div>
</body>
</html>
</html>