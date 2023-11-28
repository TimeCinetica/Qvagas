<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/components/resume/performance.css') }}">
    </link>
</head>

<div id="performance" class=" card card-shadow">
    <div class="card-body">
        <div class="row">
            @if($roleId == 3)
            <div class="info-label"><label>Última Atualização do meu currículo: </label> {{$user['updatedAtDate']}} às {{$user['updatedAtTime']}} hrs</div>
            @else
            <div class="info-label"><label>Última Atualização do currículo: </label> {{$user['updatedAtDate']}} às {{$user['updatedAtTime']}} hrs</div>
            @endif
        </div>
        <div class="row">
            <div class="info-label">
                <label>Status do currículo: </label>
                <div class="d-flex">
                    @if($roleId == 3)
                    {{$user['resumeStatus']['name']}}
                    <i class="bi bi-info-circle-fill" data-micromodal-trigger="modal-1"></i>
                    @else
                    <select class="form-select" name="statusId" id="statusId" disabled>
                        <option value="1" {{$user['resumeStatus']['id'] == 1 ? ' selected' : '' }}>Não avaliado</option>
                        <option value="2" {{$user['resumeStatus']['id'] == 2 ? ' selected' : '' }}>Não qualificado</option>
                        <option value="3" {{$user['resumeStatus']['id'] == 3 ? ' selected' : '' }}>Qualificado</option>
                        <option value="4" {{$user['resumeStatus']['id'] == 4 ? ' selected' : '' }}>Contratado</option>
                        <option value="5" {{$user['resumeStatus']['id'] == 5 ? ' selected' : '' }}>Banco de Dados</option>
                        <option value="6" {{$user['resumeStatus']['id'] == 6 ? ' selected' : '' }}>Standy By</option>
                        <option value="7" {{$user['resumeStatus']['id'] == 7 ? ' selected' : '' }}>Alinhamento com a vaga</option>
                        <option value="8" {{$user['resumeStatus']['id'] == 8 ? ' selected' : '' }}>Espera do contato do contratante</option>
                        <option value="9" {{$user['resumeStatus']['id'] == 9 ? ' selected' : '' }}>Testes e Questionário</option>
                        <option value="10" {{$user['resumeStatus']['id'] == 10 ? ' selected' : '' }}>Sem candidatura</option>
                        <option value="11" {{$user['resumeStatus']['id'] == 11 ? ' selected' : '' }}>Entrevista com o contratante</option>
                        <option value="12" {{$user['resumeStatus']['id'] == 12 ? ' selected' : '' }}>Entrevista com Recrutador</option>
                    </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="info-label">
                <label>Avaliação da Equipe do QVagas: </label>
                <div class="d-flex">
                    @if($roleId == 3)
                    {{$user['evaluated'] ? 'Realizado' : 'Não Realizado'}}
                    <i class="bi bi-info-circle-fill" data-micromodal-trigger="modal-2"></i>
                    @if(!$user['evaluated'])
                    <a href="https://qvagas.quallitypsi.com.br/index.php/avaliacao-da-equipe-da-qvagas/" target="_blank" class="btn btn-primary small-button">Solicitar avaliação</a>
                    @endif
                    @else
                    <select class="form-select" name="evaluated" id="evaluated" disabled>
                        <option value="0" {{$user['evaluated'] == 0 ? ' selected' : '' }}>Não Realizado</option>
                        <option value="1" {{$user['evaluated'] == 1 ? ' selected' : '' }}>Realizado</option>
                    </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="info-label">
                <label>Selo de Talentos do LabCarreiras: </label>
                <div class="d-flex">
                    @if($roleId == 3)
                    {{$user['stamped'] ? 'Realizado' : 'Não Realizado'}}
                    <i class="bi bi-info-circle-fill" data-micromodal-trigger="modal-3"></i>
                    @if(!$user['stamped'])
                    <a href="https://labcarreiras.com.br/cadastro/" target="_blank" class="btn btn-primary small-button">Fazer parte</a>
                    @endif
                    @else
                    <select class="form-select" name="stamped" id="stamped" disabled>
                        <option value="0" {{$user['stamped'] == 0 ? ' selected' : '' }}>Não Realizado</option>
                        <option value="1" {{$user['stamped'] == 1 ? ' selected' : '' }}>Realizado</option>
                    </select>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(() => MicroModal.init(), 1500)
</script>