<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/occupations/index.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css']
])

<body id="occupations-page" onload='initTable(@json($occupations), @json($policies))'>
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="row">
                <div class="header">
                    <h2>Lista de profissões</h2>
                    <a type="button" class="btn btn-primary btn-dft" onclick="addOccupation()">
                        Adicionar <i class="bi bi-plus-square"></i>
                    </a>
                </div>
            </div>
            <form onsubmit="filter(event)" id="filter-form">
                <div class="d-flex align-items-center justify-content-center submit-filter">
                    <input type="text" placeholder="Nome da profissão" class="form-control" id="search" name="search">
                    <button class="btn btn-primary d-flex flex-row">
                        Filtrar <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
            <table id="occupations-table" class="table table-striped fast-table">
                <thead>
                    <tr>
                        <th class="text-center  ordeble-column" onclick="orderBy()">Nome <i id="order-filter-icon" class="bi bi-caret-down"></i></th>
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
                {{ $occupations->links() }}
            </div>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>