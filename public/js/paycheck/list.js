function addCooperator() {
    redirect("contracheque/new");
}



function addPaycheck(name) {
    _upsertPaycheck("Novo Contracheque", _addPaycheck, { name: name });
}

function _upsertPaycheck(title, actionFn, params = null) {
    const name = params && params.name ? params.name : "";
    Swal.fire({
        title: title,
        html: `
            <input id="name" type="text" value="${name}" readonly />
            <input id="file" type="file" />
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Salvar",
        cancelButtonText: "Voltar",
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "var(--primary)",
        preConfirm: () => {
            const data = params ? { ...params, name } : name;
            const file = document.getElementById('file').files[0];
            actionFn(data, file);
            return false;
        },
        didOpen: () => {
            $(".swal2-confirm").attr("id", "swal2-confirm");
            $(".swal2-cancel").attr("id", "swal2-cancel");
        },
    });
}


function _addPaycheck(name) {
    const data = { name };
    const endpoint = url("occupations");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", data, _onSuccessUpsertOccupation, _onUpsertFail);
}
