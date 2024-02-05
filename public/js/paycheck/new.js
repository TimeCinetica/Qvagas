(function () {
    setTimeout(() => {
        maskCpf("cpf");
    }, 250);
})();

/**
 *
 */
function storeAdmin(event) {
    event.preventDefault();
    const formIsValid = validateForm("new-admin-form");

    if (formIsValid) {
        const data = {
            name: $("#name").val(),
            admin_responsed: $("#admin_responsed").val(),
            cpf: normalizeNumber($("#cpf").val()),
            email: $("#email").val(),
            roleId: $("#role").val(),
            password: $("#password").val(),
        };

        const passwordConfirm = $("#password-confirm").val();
        const passwordIsValid = _validatePassword(
            data.password,
            passwordConfirm
        );

        if (passwordIsValid && !getIsLoading()) {
            setIsLoading(true, "new-button");
            const endpoint = url("admin/new");
            request(endpoint, "POST", data, _onStoreSuccess, _onStoreFail);
        }
    }
}

/**
 *
 * @param {string} password
 * @param {string} confirmation
 */
function _validatePassword(password, confirmation) {
    if (password !== confirmation) {
        toast("Ops...", "A senha e sua confirmação não batem", "danger");
        return false;
    }

    return true;
}

/**
 *
 */
function _onStoreFail(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "new-button");
}

/**
 *
 */
function _onStoreSuccess(response) {
    sweetAlert(
        "success",
        "Sucesso!",
        "Novo admin cadastrado com sucesso.",
        (r) => redirect("contracheque")
    );
    setIsLoading(false, "new-button");
}
