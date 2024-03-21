// Função para adicionar eventos de clique
function addClickEvents() {
    $('.accordion-toggle').off('click').on('click', function() {
        // Verifica se a linha está oculta
        if (this.style.display !== "none") {
            var arrowIcon = this.querySelector('i');
            arrowIcon.classList.toggle('bi-chevron-down');
            arrowIcon.classList.toggle('bi-chevron-up');
        }
    });
}

// Função de filtro
function filterCollaborator(event) {
    event.preventDefault(); // Evita o comportamento padrão do formulário

    var input = document.getElementById('search'); // Obtém o elemento de entrada
    var filter = input.value.toUpperCase(); // Obtém o valor do filtro e converte para maiúsculas
    var table = document.getElementById('list-colaborators-table'); // Obtém a tabela
    var tr = table.getElementsByTagName('tr'); // Obtém todas as linhas da tabela

    // Percorre todas as linhas da tabela
    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName('td')[0]; // Obtém a primeira célula de cada linha (nome)
        if (td) {
            var txtValue = td.textContent || td.innerText; // Obtém o texto da célula
            // Verifica se o texto da célula corresponde ao filtro
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = ""; // Mostra a linha se corresponder
                // Obtém o ID do elemento que é mostrado/ocultado quando a linha é clicada
                var targetId = tr[i].getAttribute('data-target');
                // Expande o elemento
                $(targetId).collapse('show');
            } else {
                // Verifica se a linha é uma linha interna da tabela
                if (!tr[i].classList.contains('accordion-toggle')) {
                    continue; // Ignora as linhas internas da tabela
                }
                tr[i].style.display = "none"; // Esconde a linha se não corresponder
                // Obtém o ID do elemento que é mostrado/ocultado quando a linha é clicada
                targetId = tr[i].getAttribute('data-target');
                // Colapsa o elemento
                $(targetId).collapse('hide');
            }
        }
    }

    // Reanexa os eventos de clique após a filtragem
    addClickEvents();
}



function addCooperator() {
    redirect("contracheque/new");
}

function addPaycheck(name) {
    _upsertPaycheck("Novo Contracheque", _addPaycheck, { name: name });
}

function _upsertPaycheck(title, actionFn, params = null, isEdit = false) {
    const name = params && params.name ? params.name : "";
    const id = isEdit && params && params.id ? params.id : null;
    const month_year = isEdit && params && params.month_year ? params.month_year : "";
    const name_paycheck = isEdit && params && params.name_paycheck ? params.name_paycheck : "";

    const options = [
        {value: "Cálculo Mensal", title: "Refere-se ao salário ou pagamento regular que um funcionário recebe mensalmente. Geralmente é um valor fixo acordado no contrato de trabalho e é pago por mês trabalhado."},
        {value: "1° Parcela do 13°", title: "No Brasil, o 13º salário é uma gratificação de Natal que deve ser paga em duas parcelas. A primeira parcela deve ser paga entre 1º de fevereiro e 30 de novembro de cada ano."},
        {value: "2° Parcela do 13°", title: "A segunda parcela do 13º salário deve ser paga até o dia 20 de dezembro, completando o valor total do 13º. O valor é a diferença entre o total do 13º salário e o valor já pago na primeira parcela."},
        {value: "13° Valor total", title: ""},
        {value: "Folha Complementar", title: "Uma folha de pagamento adicional que é processada fora do ciclo normal de pagamento mensal. Pode ser usada para corrigir erros, fazer ajustes salariais retroativos, pagar bônus ou compensar horas extras, por exemplo."},
        {value: "Vale", title: "Também conhecido como adiantamento salarial, é uma parte do salário que é pago antecipadamente ao funcionário, antes da data regular de pagamento. Geralmente, é descontado no pagamento subsequente."},
        {value: "Férias", title: "O pagamento de férias é feito quando um funcionário tira seus dias de férias anuais. No Brasil, além dos dias de férias, o funcionário recebe um adicional de 1/3 do valor do seu salário regular."},
        {value: "Adiantamento", title: "Similar ao vale, é um pagamento feito antes da data de pagamento regular. O adiantamento pode ser uma fração do salário mensal do funcionário, destinado a ajudar em despesas imprevistas, e é descontado no próximo pagamento."},
        {value: "Horas Extras", title: "Pagamento adicional pelas horas trabalhadas além da jornada normal de trabalho. A taxa de horas extras é geralmente maior do que a taxa de pagamento normal."},
        {value: "Adicional Noturno", title: "Um adicional pago aos trabalhadores que exercem suas funções no período noturno, conforme definido pela legislação local."},
        {value: "Adicional de Periculosidade", title: "Um pagamento extra para os funcionários que trabalham em condições perigosas ou com materiais que oferecem risco à saúde."},
        {value: "Adicional de Insalubridade", title: "Compensação para funcionários que trabalham em condições insalubres, acima dos limites tolerados pela legislação, para compensar os riscos à saúde."},
        {value: "Bônus e Gratificações", title: "Pagamentos adicionais que podem ser baseados no desempenho da empresa, do departamento ou do próprio funcionário. Não são obrigatórios e dependem da política interna da empresa."},
        {value: "Participação nos Lucros e Resultados (PLR)", title: "Um tipo de bonificação concedida aos funcionários, dependendo do lucro ou dos resultados alcançados pela empresa em um determinado período."},
        {value: "Auxílio-Alimentação e Auxílio-Transporte", title: "Benefícios concedidos para auxiliar nas despesas com alimentação e transporte do funcionário ao local de trabalho."},
        {value: "Indenizações", title: "Pagamentos feitos em situações específicas, como demissão sem justa causa ou término de contrato de trabalho, que visam compensar o funcionário."},
        {value: "Reembolso de Despesas", title: "Compensação por despesas que o funcionário (CLT ou PJ) teve em função do trabalho, como viagens, hospedagem, e alimentação em serviço externo."},
        {value: "Nota Fiscal de Serviço (NFS-e)", title: "O pagamento é realizado mediante a emissão de uma nota fiscal de serviço. É a forma pela qual o profissional PJ formaliza o serviço prestado e solicita o pagamento."},
        {value: "Honorários", title: "Refere-se ao pagamento pelos serviços prestados. Esta é uma nomenclatura comum para remunerar profissionais liberais e consultores que atuam como PJ."},
        {value: "Pagamento por Projeto", title: "Pagamento acordado pela entrega de um projeto específico, onde o valor é fixado com base no escopo do projeto e não no tempo despendido."},
        {value: "Pagamento por Hora", title: "Alguns PJs trabalham com pagamento baseado em hora de serviço. O valor é acordado por hora de trabalho e multiplicado pelas horas efetivamente trabalhadas."},
        {value: "Informe de Rendimento", title: "Documento é essencial para a declaração do Imposto de Renda Pessoa Física (IRPF), pois detalha não apenas os rendimentos tributáveis, mas também pode incluir informações sobre rendimentos isentos."},
        {value: "Pagamento por Projeto", title: ""},
        {value: "Pagamento por Hora", title: ""},
        {value: "Adiantamento ou Pagamento Parcial", title: ""},
    ];    

    let optionsHTML = options.map(option => 
        `<option value="${option.value}" ${name_paycheck === option.value ? 'selected' : ''} title="${option.title}">${option.value}</option>`
    ).join('\n');

    Swal.fire({
        title: title,
        html: `
            <form>
                <div class="form-group">
                    <input id="id" type="hidden" value="${id}" />
                </div>
                <div class="form-group">
                    <label for="name">Nome: </label>
                    <input class="form-control" id="name" type="text" value="${name}" readonly />
                </div>
                <div class="form-group">
                    <label for="name">Descrição: </label>
                    <select class="form-select" id="description" name="description" >
                        ${optionsHTML}
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Data do contracheque: </label>
                    <input class="form-control" value="${month_year || ''}" id="date" type="text" name="month_year" maxlength="7" oninput="formatDateInput(this)"/>
                </div>
                <div class="form-group">
                    <label for="file">Contracheque: </label>
                    <input class="form-control" id="file" type="file" name="paycheckpdf"/>
                </div>
            </form>
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Salvar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--primary)",
        preConfirm: () => {

            const date = document.getElementById('date').value;
            const numbers = date.replace(/\D/g, ''); // Remove non-digits
            const file = document.getElementById('file').files[0]; // Get the file
            const month_year = document.getElementById('date').value;
            const name_paycheck = document.getElementById('description').value;

            if (!file) {
                Swal.showValidationMessage('Por favor, anexe um documento PDF.');
                return false;
            }

            if (numbers.length != 6) {
                Swal.showValidationMessage('Por favor, insira um mês e um ano no formato MM/AAAA.');
                return false;
            }

            if (!isEdit) {
                actionFn(name);
            } else {
                actionFn({ id: id, name: name, month_year: month_year, name_paycheck: name_paycheck })
            }

            return false
        },
        didOpen: () => {
            $(".swal2-confirm").attr("id", "swal2-confirm");
            $(".swal2-cancel").attr("id", "swal2-cancel");
        },
    });
}

let lastValue = "";

function formatDateInput(input) {
    var value = input.value;
    value = value.replace(/[^0-9/]/g, ""); // Permitir números e barras
    if (value.length == 2 && !value.includes("/") && lastValue.length != 3) {
        value += "/"; // Adiciona uma barra após o segundo número
    }
    lastValue = value; // Atualiza o último valor
    input.value = value;
}

function _addPaycheck(name) {
    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];
    const dateInput = document.getElementById('date');
    const date = dateInput.value;
    const descriptionInput = document.getElementById('description');
    const description = descriptionInput.options[descriptionInput.selectedIndex].value;

    const formData = new FormData();

    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);
    formData.append('month_year', date);
    formData.append('name_paycheck', description);

    const endpoint = url("contracheque/store");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", formData, _onSuccessUpsertPaycheck, _onUpsertFail, true, true);
}

function _onSuccessUpsertPaycheck() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Contracheque salvo com sucesso!", (r) =>
        location.reload()
    );
}

function _onUpsertFail(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
}

// Função para editar um contracheque
function editPaycheck(id, name, month_year, name_paycheck) {
    _upsertPaycheck("Editar Contracheque", _editPaycheck, { id: id, name: name, month_year: month_year, name_paycheck: name_paycheck, }, true);
}

function _editPaycheck(params) {
    const id = params && params.id ? params.id : "";
    const name = params && params.name ? params.name : "";
    const month_year = params && params.month_year ? params.month_year : "";
    const name_paycheck = params && params.name_paycheck ? params.name_paycheck : "";

    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('id', id);
    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);
    formData.append('month_year', month_year);
    formData.append('name_paycheck', name_paycheck);

    const endpoint = url("contracheque/update");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", formData, _onSuccessUpdatePaycheck, _onUpsertFail, true, true);
}


function _onSuccessUpdatePaycheck(response) {
    Swal.close();
    sweetAlert("success", "Sucesso!", response.message, (r) => location.reload());
}


function deleteCollaborator(id) {
    const token = document.head.querySelector('meta[name="csrf-token"]').content;

    Swal.fire({
        title: 'Você tem certeza?',
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '/contracheque/delete',
                data: { id: id },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Excluído!',
                        text: response.message,
                        icon: 'success',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Erro!',
                        text: error.responseJSON.error,
                        icon: 'error',
                    });
                }
            });
        }
    });
}

function deletePaycheck(id) {
    const token = document.head.querySelector('meta[name="csrf-token"]').content;

    Swal.fire({
        title: 'Você tem certeza?',
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: `${id}/delete`,
                data: { id: id },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Excluído!',
                        text: response.message,
                        icon: 'success',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Erro!',
                        text: error.responseJSON.error,
                        icon: 'error',
                    });
                }
            });
        }
    });
}