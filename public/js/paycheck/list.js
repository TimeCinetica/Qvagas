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
            <input id="id" type="hidden" value="${id}" />
            <input id="name" type="text" value="${name}" readonly />
            <input id="file" type="file" name="paycheckpdf"/>
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Salvar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--primary)",
        preConfirm: () => {
            if (!isEdit) {
                actionFn(name);
            } else {
                actionFn({ id: id, name: name })
            }
            return false
        },
        didOpen: () => {
            $(".swal2-confirm").attr("id", "swal2-confirm");
            $(".swal2-cancel").attr("id", "swal2-cancel");
        },
    });
}


function _addPaycheck(name) {
    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);

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
function editPaycheck(id, name) {
    _upsertPaycheck("Editar Contracheque", _editPaycheck, { id: id, name: name }, true);
}

function _editPaycheck(params) {
    const id = params && params.id ? params.id : "";
    const name = params && params.name ? params.name : "";

    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('id', id);
    formData.append('nameUser', name);
    formData.append('paycheckpdf', file);

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
                url: '/paycheck/delete',
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