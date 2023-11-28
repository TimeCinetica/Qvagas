/**
 *
 */
function initTable(data, policies) {
    const cols = [
        "id",
        "name",
        "cpf",
        "email",
        "role",
        "createdAt",
        "_ACTIONS",
    ];
    const orderParam = {
        key: "name",
        defaultValue: "asc",
        index: 0,
    };

    data = _prepareAdminData(data);

    configureTable("list-admins-table", "admins", cols, orderParam, policies);

    configureTableData(data);
}

/**
 *
 */
function addAdmin() {
    redirect("admin/new");
}

/**
 *
 */
function _prepareAdminData(data) {
    for (let i = 0; i < data.data.length; i++) {
        let row = data.data[i];
        row.role = row.role.name;
        row.cpf = _maskCpf(row.cpf);
        data.data[i] = row;
    }

    return data;
}

/**
 * Metodo chamado pelo component shared/datatable.js
 */
function deleteData(data) {
    Swal.fire({
        title: "Tem certeza?",
        html: `Deseja mesmo apagar o usuário <b>${data.name}</b>?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--danger)",
        preConfirm: () => {
            _deleteAdmin(data);
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
function _deleteAdmin(data) {
    const endpoint = url(`admins/${data.id}`);
    setIsLoading(true, "swal2-confirm");
    request(endpoint, "DELETE", null, _onSuccessDeleteAdmin, _onFail);
}

/**
 *
 */
function _onSuccessDeleteAdmin() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Usuário apagado com sucesso!", (r) =>
        location.reload()
    );
}

/**
 *
 */
function _onFail(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
}
