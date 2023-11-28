/**
 *
 */
function deleteUser(userId) {
    sweetAlert(
        "warning",
        "Tem certeza?",
        "Ao exlcuir seu o cadastro, o mesmo não poderá ser desfeito.",
        r => _confirmDeleteUser(r, userId)
    );
}

/**
 *
 */
function _confirmDeleteUser(r, userId) {
    if (r.isConfirmed) {
        setIsLoading(true, "delete-button");
        const endpoint = url("user/delete");
        request(endpoint, "DELETE", null, _onSuccess, _onError);
    }
}

/**
 *
 */
function _onSuccess(response) {
    sweetAlert(
        "success",
        "Usuário excluído com sucesso!",
        "Você será deslogado e redirecionado para a página de login.",
        r => redirect("login")
    );
}

/**
 *
 */
function _onError(response) {
    console.log("change password error >> ", error);

    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "delete-button");
}
