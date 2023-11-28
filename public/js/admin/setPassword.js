(function () {
    setTimeout(() => {
        maskCpf("cpf");
    }, 250);
})();

/**
 *
 */
function setPassword(event) {
    event.preventDefault();
    const formIsValid = validateForm("set-password-form");

    if (formIsValid) {
        const data = {
            password: $("#password").val(),
        };

        const passwordConfirm = $("#password-confirm").val();
        const passwordIsValid = _validatePassword(
            data.password,
            passwordConfirm
        );

        if (passwordIsValid && !getIsLoading()) {
            setIsLoading(true, "confirm-button");
            const endpoint = url("admin/set-password");
            request(endpoint, "PUT", data, _onResetSuccess, _onResetError);
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
function _onResetError(error) {
    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "confirm-button");
}

/**
 *
 */
function _onResetSuccess(response) {
    sweetAlert("success", "Sucesso!", "Senha alterada com sucesso.", (r) =>
        redirect("")
    );
    setIsLoading(false, "confirm-button");
}
