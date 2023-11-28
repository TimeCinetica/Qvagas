/**
 *
 */
function changePassword(userId) {
    const isValid = validateForm("change-password-form");

    const password = $("#password").val();
    const passwordConfirm = $("#password-confirm").val();
    const passwordIsValid = _validatePassword(password, passwordConfirm);

    if (isValid && passwordIsValid && !getIsLoading()) {
        setIsLoading(true, "change-button");
        const data = normalizedFormData("change-password-form");
        data.userId = userId;

        const path = window.location.pathname.substring(1);
        const endpoint = url(path);
        request(endpoint, "PUT", data, _onSuccess, _onFail);
    }
}

/**
 *
 */
function _onSuccess(response) {
    sweetAlert(
        "success",
        "Senha alterada com sucesso.",
        "Lembre-se de usar a nova senha para acessar o sistema na próxima vez.",
        (r) => redirect("")
    );
}

/**
 *
 */
function _onFail(error) {
    console.log("change password error >> ", error);

    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "change-button");
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
