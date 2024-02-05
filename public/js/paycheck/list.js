function addCooperator() {
    redirect("contracheque/new");
}

function addPaycheck() {
    _upsertPaycheck("Novo Contracheque", _addPaycheck);
}

function _upsertPaycheck(title, actionFn, params = null) {
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

function _addPaycheck(name) {
    const data = { name };
    const endpoint = url("occupations");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", data, _onSuccessUpsertOccupation, _onUpsertFail);
}