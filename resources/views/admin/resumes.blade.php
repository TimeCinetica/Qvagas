<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/admin/resumes.js', 'js/shared/datatable.js'],
'css' => ['css/admin/resumes.css', 'css/shared/datatable.css']
])

<body id="resumes-page" onload='initTable(@json($resumes), @json($policies))'>
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="row">
                <div class="header">
                    <h2>Lista de currículos</h2>
                    <button class="btn btn-outline-primary" onclick="exportCsv()">Exportar em csv <i class="bi bi-download"></i></button>
                </div>
            </div>
            <form onsubmit="filter(event)" id="filter-form">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center submit-filter">
                            <div class="form-group">
                                <label for="searchName">Nome</label>
                                <input type="text" placeholder="Pesquisar por nome" class="form-control" id="searchName" name="searchName">
                            </div>
                            <div class="form-group select-filter">
                                <label for="occupations">Profissão</label>
                                <select name="occupations" multiple id="occupations" class="form-select"></select>
                            </div>
                            <div class="form-group select-filter">
                                <label for="status">Status</label>
                                <select name="status" multiple id="status" class="form-select"></select>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center submit-filter">
                            <div class="form-group select-filter">
                                <input type="checkbox" class="form-check-input" name="evaluated" id="evaluated" value="1">
                                <label for="evaluated" style="margin-top: 0.3em;">Avaliados pela Equipe do QVagas</label>
                            </div>
                            <div class="form-group select-filter">
                                <input type="checkbox" class="form-check-input" name="stamped" id="stamped" value="1">
                                <label for="stamped" style="margin-top: 0.3em;">Selo de Talentos do LabCarreiras</label>
                            </div>
                            <div class="form-group select-filter">
                                <input type="checkbox" class="form-check-input" name="deprecated" id="deprecated" value="1">
                                <label for="deprecated" style="margin-top: 0.3em;">Não atualizados há 6 meses</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-center submit-filter">
                        <button class="btn btn-primary d-flex flex-row" style="margin-top: 1.1rem;">
                            Filtrar <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
            <table id="resumes-table" class="table table-striped fast-table">
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Status</th>
                        <th class="text-center ordeble-column" onclick="orderBy()">Última atualização <i id="order-filter-icon" class="bi bi-caret-down"></i></th>
                        <th class="text-center">Cargos pretendidos</th>
                        <th class="text-center">Localização</th>
                        @if($policies->details || $policies->edit || $policies->delete)
                        <th class="text-center" id="actions">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="pages">
                {{ $resumes->links() }}
            </div>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>