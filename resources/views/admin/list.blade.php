<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/admin/list.js', 'js/shared/datatable.js'],
'css' => ['css/admin/list.css', 'css/shared/datatable.css']
])

<body id='list-admins-page' onload='initTable(@json($data), @json($policies))'>
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="row">
                <div class="header">
                    <h2>Lista de admins</h2>
                    <a type="button" class="btn btn-primary btn-dft" onclick="addAdmin()">
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
                        <th class="text-center  ordeble-column" onclick="orderBy()">Nome <i id="order-filter-icon" class="bi bi-caret-down"></i></th>
                        <th class="text-center cpf-col">CPF</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Cargo</th>
                        <th class="text-center">Data de Cadastro</th>
                        @if($policies->details || $policies->edit || $policies->delete)
                        <th class="text-center" id="actions">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="pages">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</body>

</html>