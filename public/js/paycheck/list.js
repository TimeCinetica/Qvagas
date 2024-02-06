function addCooperator() {
    redirect("contracheque/new");
}



function addPaycheck(name) {
    _upsertPaycheck("Novo Contracheque", _addPaycheck, { name: name });
}

function _upsertPaycheck(title, actionFn, params = null) {
    const name = params && params.name ? params.name : "";
    let data;
    Swal.fire({
        title: title,
        html: `
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
            data = params ? { ...params, name } : name;
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
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('paycheckpdf', file);

    const endpoint = url("contracheque");

    setTimeout(() => $("#swal2-cancel").attr("disabled", "disabled"), 0);

    setIsLoading(true, "swal2-confirm");
    request(endpoint, "POST", formData, _onSuccessUpsertPaycheck, _onUpsertFail);
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