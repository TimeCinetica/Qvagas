var _toggled = true;

(() => {
    setTimeout(() => {
        loadResumeStatus();
    }, 250);
})();

/**
 *
 */
function loadResumeStatus() {
    const endpoint = url("resumes/status");
    request(endpoint, "GET", null, _onSuccessStatus, _onFailStatus);
}

/**
 *
 */
function toggleCards() {
    const text = _toggled ? "Ver menos" : "Ver mais";
    const icon = _toggled ? "bi bi-dash" : "bi bi-plus";

    $("#toggle-btn i").removeClass();
    $("#toggle-btn i").addClass(icon);
    $("#toggle-btn p").text(text);

    _toggled = !_toggled;
}

function _onSuccessStatus(response) {
    for (const data of response) {
        $(`#status${data.statusId}`).text(data.total);
    }
}

function _onFailStatus(error) {
    console.log("on load resume by status error >> ", getErrorMessage(error));
}
