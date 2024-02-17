// Função para adicionar eventos de clique
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
                var targetId = tr[i].getAttribute('data-target');
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
                    <label for="date">Data do contracheque: </label>
                    <input class="form-control" id="date" type="text" name="month_year" maxlength="7" oninput="formatDateInput(this)"/>
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
                actionFn({ id: id, name: name, month_year: month_year })
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

    const formData = new FormData();

    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);
    formData.append('month_year', date);

    const endpoint = url("contracheque/store");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", formData, _onSuccessUpsertPaycheck, _onUpsertFail, true, true);
}

function _onSuccessUpsertPaycheck() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Profissão salva com sucesso!", (r) =>
        location.reload()
    );
}

function _onUpsertFail(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
}

// Função para editar um contracheque
function editPaycheck(id, name, month_year) {
    _upsertPaycheck("Editar Contracheque", _editPaycheck, { id: id, name: name, month_year: month_year }, true);
}

function _editPaycheck(params) {
    const id = params && params.id ? params.id : "";
    const name = params && params.name ? params.name : "";
    const month_year = params && params.month_year ? params.month_year : "";

    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('id', id);
    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);
    formData.append('month_year', month_year);

    const endpoint = url("contracheque/update");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", formData, _onSuccessUpdatePaycheck, _onUpsertFail, true, true);
}


function _onSuccessUpdatePaycheck(response) {
    Swal.close();
    sweetAlert("success", "Sucesso!", response.message, (r) => location.reload());
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
                url: 'contracheque/delete',
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