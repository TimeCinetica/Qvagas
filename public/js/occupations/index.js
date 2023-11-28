/**
 *
 */
function initTable(data, policies) {
    const cols = ["id", "name", "createdAt", "_ACTIONS"];
    const orderParam = {
        key: "name",
        defaultValue: "asc",
        index: 0,
    };

    configureTable(
        "occupations-table",
        "occupations",
        cols,
        orderParam,
        policies
    );

    configureTableData(data);
}

/**
 *
 */
function addOccupation() {
    _upsertOccupation("Nova profissão", _addOccupation);
}

/**
 * Metodo chamado pelo component shared/datatable.js
 */
function editData(data) {
    _upsertOccupation("Editar profissão", _editOccupation, data);
}

/**
 * Metodo chamado pelo component shared/datatable.js
 */
function deleteData(data) {
    Swal.fire({
        title: "Tem certeza?",
        html: `Deseja mesmo apagar a profissão <b>${data.name}</b>?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--danger)",
        preConfirm: () => {
            _deleteOccupation(data);
            return false;
        },
        didOpen: () => {
            $(".swal2-confirm").attr("id", "swal2-confirm");
            $(".swal2-cancel").attr("id", "swal2-cancel");
        },
    });
}

/**
 *
 */
function _upsertOccupation(title, actionFn, params = null) {
    const text = params && params.name ? params.name : "";
    Swal.fire({
        title: title,
        input: "text",
        icon: "question",
        inputValue: text,
        showCancelButton: true,
        confirmButtonText: "Salvar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--primary)",
        preConfirm: (name) => {
            const data = params ? { ...params, name } : name;
            actionFn(data);
            return false;
        },
        didOpen: () => {
            $(".swal2-confirm").attr("id", "swal2-confirm");
            $(".swal2-cancel").attr("id", "swal2-cancel");
        },
    });
}

/**
 *
 */
function _addOccupation(name) {
    const data = { name };
    const endpoint = url("occupations");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", data, _onSuccessUpsertOccupation, _onUpsertFail);
}

/**
 *
 */
function _editOccupation(data) {
    const name = { name: data.name };
    const endpoint = url(`occupations/${data.id}`);

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "PUT", name, _onSuccessUpsertOccupation, _onUpsertFail);
}

/**
 *
 */
function _deleteOccupation(data) {
    const endpoint = url(`occupations/${data.id}`);
    setIsLoading(true, "swal2-confirm");
    request(
        endpoint,
        "DELETE",
        null,
        _onSuccessDeleteOccupation,
        _onUpsertFail
    );
}

/**
 *
 */
function _onUpsertFail(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
}

/**
 *
 */
function _onSuccessUpsertOccupation() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Profissão salva com sucesso!", (r) =>
        location.reload()
    );
}

/**
 *
 */
function _onSuccessDeleteOccupation() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Profissão apagada com sucesso!", (r) =>
        location.reload()
    );
}
