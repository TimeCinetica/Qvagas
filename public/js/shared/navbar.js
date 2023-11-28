(function() {
    // setTimeout(_initState, 10);
})();

/**
 *
 */
function logout() {
    const endpoint = url("logout");
    request(endpoint, "POST", null, null, _logoutError);
    redirect("login");
}

/**
 *
 */
function _logoutError(response) {
    console.log("logout error >>", response);
    console.log(response);
}

/**
 *
 */
function _initState() {
    $(`nav a[href$="${location.pathname}"]`).addClass("active");
}

/**
 *
 */
function goToResume(userId) {
    redirect(`${userId}/resume`);
}
