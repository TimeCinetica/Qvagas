<?php
    function translateMonth($monthName) {
        $months = [
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Setembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        ];
        
        return $months[$monthName] ?? $monthName;
    }
    
    
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/list.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css']
])

<body id="paycheck-cooperators-page" onload='initTable(@json($admins_list), @json($policies))'>
    @include('shared.nav')
    <div class="container">
    <div class="col">
            <div class="row mt-5">
                <div class="header d-flex gap-5">
                    <h2><strong>Lista de colaboradores</strong></h2>
                    <a type="button" class="btn btn-primary btn-dft" onclick="addCooperator()">
                    Adicionar <i class="bi bi-plus-square"></i>
                    </a>
                </div>
            </div>
            <form onsubmit="filterCollaborator(event)" id="filter-form">
                <div class="d-flex align-items-center justify-content-center submit-filter">
                    <input type="text" placeholder="Nome do usuário admin" class="form-control" id="search" name="search">
                    <button class="btn btn-primary d-flex flex-row">
                        Filtrar <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
            <table id="list-colaborators-table" class="table table-striped fast-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="text-center">Profissão</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Ultima atualização</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Contracheques</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                <tr data-toggle="collapse" data-target="#user-{{ $user->id }}" class="accordion-toggle" style="cursor: pointer;">
                    <td colspan="6" class="text-center">
                        <div class="d-flex align-items-center justify-content-between px-3">
                            <div><a style="text-decoration: none; font-size: 20px; color: black;" href="{{ route('paycheck.collaborator', $user->id ) }}">+</a></div>
                            <div><strong>{{ $user->name }}</strong></div>
                            <div><i class="bi bi-chevron-down" id="arrow-{{ $user->id }}"></i></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="padding: 0 !important;">
                        <div class="collapse" id="user-{{ $user->id }}" >
                            <table class="table" style="table-layout: fixed;">
                                <tr>
                                    <td class="text-center">{{$user->job}}</td>
                                    <td class="text-center" style="word-wrap: break-word;">{{$user->email}}</td>
                                    <td class="text-center">{{$user->updated_at}}</td>
                                    <td class="text-center">@if($user->status == 0)Ativo @else Inativo @endif</td>
                                    <td>
                                        <center><a class="btn btn-primary btn-dft" onclick="addPaycheck('{{ $user->name }}')">Novo<i class="bi bi-plus-square text-white"></i></a></center>
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-danger bi-trash btn-smon" onclick="deleteCollaborator('{{$user->id}}')"></i>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    <br>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    document.querySelectorAll('.accordion-toggle').forEach(function(userRow) {
        userRow.addEventListener('click', function() {
            var arrowIcon = this.querySelector('i');
            arrowIcon.classList.toggle('bi-chevron-down');
            arrowIcon.classList.toggle('bi-chevron-up');
        });
    });

    </script>
    
</body>
</html>