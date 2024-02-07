<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/list.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css']
])

<body id="paycheck-cooperators-page">
    @include('shared.nav')
    <div class="container">
    <div class="col">
            <div class="row">
                <div class="header">
                    <h2>Lista de colaboradores</h2>
                    <a type="button" class="btn btn-primary btn-dft" onclick="addCooperator()">
                    Adicionar <i class="bi bi-plus-square"></i>
                    </a>
                </div>
            </div>
            <form onsubmit="filter(event)" id="filter-form">
                <div class="d-flex align-items-center justify-content-center submit-filter">
                    <input type="text" placeholder="Nome do usuário admin" class="form-control" id="search" name="search">
                    <button class="btn btn-primary d-flex flex-row">
                        Filtrar <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
            <table id="list-admins-table" class="table table-striped fast-table">
                <thead>
                    <tr>
                        {{--<th class="text-center ordeble-column" onclick="orderBy()">Nome <i id="order-filter-icon" class="bi bi-caret-down"></i></th>--}}
                        <th class="text-center">Nome</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Cargo</th>
                        <th class="text-center">Data de Cadastro</th>
                        <th class="text-center">Contracheques</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <div class="d-flex ">
                        <td class="text-center">
                            <a href="{{route("paycheck.collaborator", $user->id)}}">{{ $user->name }}</a>
                        </td>
                        <td class="text-center">{{$user->email}}</td>
                        <td class="text-center">{{$user->roleId}}</td>
                        <td class="text-center">{{$user->created_at}}</td>
                        <td class="text-center">
                            @foreach ($user->paychecks as $paycheck)
                                <div>
                                    <a href="{{ Storage::url($paycheck->paycheckpdf) }}">Ver Contracheque</a>
                                </div>
                            @endforeach
                            <center><a type="button" class="btn btn-primary btn-dft" onclick="addPaycheck('{{ $user->name }}')">
                            <i class="bi bi-plus-square"></i>
                            </a></center>
                        </td>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

    <br>
    


    </div>
    
</body>
</html>