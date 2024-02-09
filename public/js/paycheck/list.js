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
            <input id="file" type="file" name="paycheckpdf"/>
            <input id="date" type="text" name="month_year" maxlength="7" oninput="formatDateInput(this)"/>
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

            if (!file) {
                Swal.showValidationMessage('Por favor, anexe um documento PDF.');
                return false;
            }

            if (numbers.length != 6) {
                Swal.showValidationMessage('Por favor, insira um mês e um ano no formato MM/AAAA.');
                return false;
            }

            actionFn(name);
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

    const endpoint = url("contracheque");

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