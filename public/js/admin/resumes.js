var _statuses = [
    { id: 1, name: "Não avaliado" },
    { id: 2, name: "Não qualificado" },
    { id: 3, name: "Qualificado" },
    { id: 4, name: "Contratado" },
    { id: 5, name: "Banco de Dados" },
    { id: 6, name: "Standy By" },
    { id: 7, name: "Alinhamento com a vaga" },
    { id: 8, name: "Espera do contato do contratante" },
    { id: 9, name: "Testes e Questionário" },
    { id: 10, name: "Sem candidatura" },
    { id: 11, name: "Entrevista com o contratante" },
    { id: 12, name: "Entrevista com Recrutador" },
];

(() => {
    setTimeout(() => {
        _renderOccupations();
        _renderStatus();
        _renderCheckbox();
    }, 100);
})();

/**
 *
 */
function initTable(data, policies) {
    data.data = _unwrapInfos(data.data);

    const cols = [
        "id",
        "name",
        "status",
        "createdAt",
        "occupations",
        "location",
        "_ACTIONS",
    ];

    const orderParam = {
        key: "lastUpdate",
        defaultValue: "asc",
        index: 2,
    };

    configureTable("resumes-table", "resumes", cols, orderParam, policies);

    configureTableData(data);
}

/**
 *
 */
function detailsData(data) {
    const endpoint = url(`${data.userId}/resume`);
    window.open(endpoint);
}

/**
 *
 */
function deleteData(data) {
    Swal.fire({
        title: "Tem certeza?",
        html: `Deseja mesmo apagar o currículo de <b>${data.name}</b>?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--danger)",
        preConfirm: () => {
            _deleteResume(data);
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
function exportCsv() {
    const endpoint = url(`resumes/export-csv${window.location.search}`);
    window.open(endpoint);
}

/**
 *
 */
function _deleteResume(data) {
    const endpoint = url(`resumes/${data.id}`);
    setIsLoading(true, "swal2-confirm");
    request(
        endpoint,
        "DELETE",
        null,
        _onSuccessDeleteResume,
        _onFailDeleteResume
    );
}

/**
 *
 */
function _unwrapInfos(data) {
    let newData = [];
    for (let resume of data) {
        const occupationsNames = resume.occupations.map(
            (occupation) => occupation.name
        );

        const obj = {
            id: resume.id,
            userId: resume.user.id,
            status: resume.status.name,
            name: resume.user.name,
            created_at: resume.lastUpdate,
            location: `${resume.user.city.name}/${resume.user.state.abbr}`,
            occupations: occupationsNames.join(" - "),
        };

        newData.push(obj);
    }

    return newData;
}

/**
 *
 */
function _renderOccupations() {
    const endpoint = url("api/occupations");
    request(endpoint, "GET", null, (data) => {
        const select = $("#occupations");
        for (occupation of data) {
            select.append(
                `<option value="${occupation.id}">${occupation.name}</option>`
            );
        }

        select.select2({
            width: null,
            placeholder: "Pesquisar por profissão",
            language: { noResults: () => "Nenhuma profssão encotrada" },
        });

        const params = new URLSearchParams(window.location.search);
        if (params.has("occupations")) {
            const value = params.get("occupations");
            const occupations = value.split(",");
            const select = $("#occupations");
            select.val(occupations);
            select.trigger("change");
        }
    });
}

/**
 *
 */
function _renderStatus() {
    const select = $("#status");
    for (let status of _statuses) {
        select.append(`<option value="${status.id}">${status.name}</option>`);
    }

    select.select2({
        width: null,
        placeholder: "Pesquisar por status",
    });

    const params = new URLSearchParams(window.location.search);
    if (params.has("status")) {
        const value = params.get("status");
        const status = value.split(",");
        const select = $("#status");
        select.val(status);
        select.trigger("change");
    }
}

/**
 *
 */
function _renderCheckbox() {
    const params = new URLSearchParams(window.location.search);
    if (params.has("evaluated")) {
        $("#evaluated").prop("checked", true);
    }
    if (params.has("stamped")) {
        $("#stamped").prop("checked", true);
    }
    if (params.has("deprecated")) {
        $("#deprecated").prop("checked", true);
    }
}

/**
 *
 */
function _onSuccessDeleteResume() {
    Swal.close();
    sweetAlert("success", "Sucesso!", "Currículo apagado com sucesso!", (r) =>
        location.reload()
    );
}

/**
 *
 */
function _onFailDeleteResume(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
}
