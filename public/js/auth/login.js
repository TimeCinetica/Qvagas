(function() {
    setTimeout(() => {
        maskCpf("cpf");
    }, 250);
})();
/**
 *
 */
function login(event) {
    event.preventDefault();
    let formIsValid = validateForm("login-form");

    if (formIsValid && !getIsLoading()) {
        const obj = {
            cpf: normalizeNumber($("#cpf").val()),
            password: $("#password").val()
        };

        setIsLoading(true, "login-button");
        const endpoint = url("login");
        request(endpoint, "POST", obj, _onLoginSuccess, _onLoginFail);
    }
}

function _onLoginSuccess(token) {
    setIsLoading(false, "login-button");
    redirect("");
}

function _onLoginFail(error) {
    setIsLoading(false, "login-button");
    const message =
        error.status === 401
            ? "CPF ou senha inválidos"
            : getErrorMessage(error);
    toast("Ops!", message, "danger");
}
