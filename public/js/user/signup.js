var _viaCepInProgress = false;
var _toUpload = {};
var _companyCount = 1;
var _languageCount = 1;
var _states = [];

(function () {
    setTimeout(() => {
        maskCpf("cpf");
        maskCellphone("cellphone");
        maskCellphone("cellphone-2");
        maskCep("cep");
        maskCurrency("salary");
        maskCurrency("last-salary");
        datepicker("birth-date");
        addExpirence();
        addLanguage();
        enableTooltips();
        _showPcdReportInput();
        _renderOccupations();
        _fillAddress();
        _hideOther("sex", "other-sex");
        _hideOther("civil", "other-civil");
        _hideOther("volunteer-work", "other-volunteer-work", 1);
        _hideOther("has-children", "other-has-children");
        _loadStates();
        _listenStateChange();
    }, 250);
})();

/**
 *
 */
function goToPersonalHistory() {
    _validatePreviousSections(1);
}

/**
 *
 */
function goToProfessionalGoals() {
    _validatePreviousSections(2);
}

/**
 *
 */
function goToProfessionalHistory() {
    _validatePreviousSections(3);
}

/**
 *
 */
function goToProfessionalExperience() {
    _validatePreviousSections(4);
}

/**
 *
 */
function goToComplementaryData() {
    _validatePreviousSections(5);
}

/**
 *
 */
function validateAll() {
    return _validatePreviousSections(6, true);
}

/**
 *
 */
function handlePhoto(name, files) {
    _toUpload[name] = files[0];
}

/**
 *
 */
function addExpirence() {
    const template = _experienceTemplate(_companyCount);
    const buttomTemplate = _experienceButtonTemplate(_companyCount);
    if (_companyCount == 1) {
        $("#company-buttons").prepend(template);
    } else {
        $(template).insertAfter(`#company-${_companyCount - 1}`);
        $(`#last-row-company-${_companyCount}`).append(buttomTemplate);
    }
    datepicker(`company-${_companyCount}-start`);
    datepicker(`company-${_companyCount}-end`);
    _companyCount++;
}

/**
 *
 */
function removeExpirence(id) {
    if (id > 1) {
        $(`#company-${id}`).remove();
        _companyCount--;
    }
}

/**
 *
 */
function addLanguage() {
    const template = _languageTemplate(_languageCount);
    const buttomTemplate = _languageButtonTemplate(_languageCount);
    if (_languageCount == 1) {
        $("#language-buttons").prepend(template);
    } else {
        $(template).insertAfter(`#language-${_languageCount - 1}`);
        $(`#last-row-language-${_languageCount}`).append(buttomTemplate);
    }
    _languageCount++;
}

/**
 *
 */
function removeLanguage(id) {
    if (id > 1) {
        $(`#language-${id}`).remove();
        _languageCount--;
    }
}

/**
 *
 */
function signup() {
    const allValid = validateAll();
    const accepted = validateForm("accept-terms-form");

    if (allValid && accepted) {
        const personalData = normalizedFormData("signup-personal");
        personalData.birthDate = formatDate(personalData.birthDate);
        personalData.cpf = normalizeNumber(personalData.cpf);
        personalData.cellphone = normalizeNumber(personalData.cellphone);
        personalData.cellphone2 = normalizeNumber(personalData.cellphone2);
        personalData.cep = normalizeNumber(personalData.cep);
        personalData.rg = normalizeNumber(personalData.rg);

        const historyPersonal = normalizedFormData("signup-history-personal");
        const professionalGoals = normalizedFormData(
            "signup-professional-goals"
        );
        const professionalHistory = normalizedFormData("professional-history");

        const complementaryData = _complementaryDataForm();

        const allFormData = {
            ...personalData,
            ...historyPersonal,
            ...professionalGoals,
            ...professionalHistory,
            ...complementaryData,
            resumeCompanies: _normalizeResumeCompanies(),
            resumeLanguagues: _normalizeResumeLanguages(),
        };

        const passwordConfirm = $("#password-confirm").val();
        passwordIsValid = _validatePassword(
            complementaryData.password,
            passwordConfirm
        );

        if (!getIsLoading() && passwordIsValid) {
            setIsLoading(true, "signup-button");
            const signupEndpoint = url("api/signup");
            request(
                signupEndpoint,
                "POST",
                allFormData,
                null,
                _onSignupFail
            ).then((response) => {
                const uploadEndpoint = url("api/user/photos");
                const data = {
                    userId: response.id,
                    ..._toUpload,
                };

                request(
                    uploadEndpoint,
                    "POST",
                    toFormData(data),
                    _onSignupSuccess,
                    _onSignupFail,
                    true,
                    true
                );
            });
        }
    }
}

/**
 *
 */
function _loadStates() {
    const endpoint = url("states");
    request(endpoint, "GET", null, _renderStates, (err) => console.log(err));
}

/**
 *
 */
function onActualJobChanged(id) {
    const checked = $(`#actual-job-${id}`).is(":checked");
    const companyEnd = $(`#company-${id}-end`);
    datepicker(`company-${id}-end`);
    companyEnd.prop("disabled", checked);
}

/**
 *
 */
function _onSignupSuccess(response) {
    setIsLoading(false, "signup-button");
    sweetAlert(
        "success",
        "Conta criada com sucesso!",
        "Você pode fazer o login agora.",
        (r) => redirect("login")
    );
}

/**
 *
 */
function _onSignupFail(error) {
    console.log("Signup error >> ", error);

    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "signup-button");
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
function _fillAddress() {
    const cepField = $("#cep");
    cepField.on("keyup", () => {
        const value = cepField.val();

        if (value.length >= 9 && !_viaCepInProgress) {
            _viaCepInProgress = true;
            const url = `https://viacep.com.br/ws/${value}/json`;
            request(
                url,
                "GET",
                null,
                _handleViaCepSuccess,
                _handleViaCepFail,
                false
            );
        }
    });
}

/**
 *
 */
function _hideOther(inputId, otherId, hideValue = 0) {
    const field = $(`#${inputId}`);
    field.on("change", () => {
        const value = field.val();
        _hideOtherField(otherId, value, hideValue);
    });
}

/**
 *
 */
function _hideOtherField(otherId, value, hideValue) {
    const otherField = $(`#${otherId}`);
    const otherLabel = $(`label[for=${otherId}]`);

    if (value != hideValue) {
        otherField.hide();
        otherField.removeAttr("required");
        otherLabel.hide();
    } else {
        otherField.show();
        otherField.attr("required", "true");
        otherLabel.show();
    }
}

/**
 *
 */
function _handleViaCepSuccess(response) {
    _viaCepInProgress = false;
    if (response.erro) {
        toast(
            "Ops...",
            "CEP não encontrado, verique se está correto.",
            "danger"
        );
    } else {
        $("#address").val(response.logradouro);
        $("#district").val(response.bairro);

        if (_states) {
            const state = _states.find((state) => state.abbr == response.uf);
            const stateSelect = $("#stateId");
            stateSelect.val(state.id);
            _renderCities(state.id, true, response.localidade);
        }
    }
}

/**
 *
 */
function _handleViaCepFail(error) {
    _viaCepInProgress = false;
}

/**
 *
 */
function _successIcon(iconId) {
    const icon = $(`#${iconId}`);
    _resetIcon(icon);
    icon.addClass("bi-check-circle text-success-qvagas");
}

/**
 *
 */
function _errorIcon(iconId) {
    const icon = $(`#${iconId}`);
    _resetIcon(icon);
    icon.addClass("bi-x-circle text-danger-qvagas");
}

/**
 *
 */
function _resetIcon(icon) {
    icon.removeClass("bi-exclamation-circle text-warning");
    icon.removeClass("bi-check-circle text-success-qvagas");
    icon.removeClass("bi-x-circle text-danger-qvagas");
}

/**
 *
 */
function _validateSection(
    formId,
    iconId,
    hideId,
    showId,
    move = true,
    lastSection = false
) {
    const formIsValid = validateForm(formId);

    if (formIsValid) {
        _successIcon(iconId);
        if (move) {
            $(`#${hideId}`).collapse("hide");
            if (!lastSection) {
                $(`#${showId}`).collapse("show");
            }
        }
    } else {
        _errorIcon(iconId);
    }

    return formIsValid;
}

/**
 *
 */
function _validatePreviousSections(n, lastSection = false) {
    const formIds = [
        "signup-personal",
        "signup-history-personal",
        "signup-professional-goals",
        "professional-history",
        "professional-experience",
        "complementary-data",
    ];

    const formIconsIds = [
        "icon-status-one",
        "icon-status-two",
        "icon-status-three",
        "icon-status-four",
        "icon-status-five",
        "icon-status-six",
    ];

    const collapseIds = [
        ["collapseOne", "collapseTwo"],
        ["collapseTwo", "collapseThree"],
        ["collapseThree", "collapseFour"],
        ["collapseFour", "collapseFive"],
        ["collapseFive", "collapseSix"],
        ["collapseSix", "collapseSix"],
    ];

    let validSections = false;
    for (let i = 1; i <= n; i++) {
        const formId = formIds[i - 1];
        const formIconId = formIconsIds[i - 1];
        const collapseId = collapseIds[i - 1];
        const move = i == n;

        validSections = _validateSection(
            formId,
            formIconId,
            ...collapseId,
            move,
            lastSection
        );
    }

    return validSections;
}

/**
 *
 */
function _renderOccupations() {
    const endpoint = url("api/occupations");
    request(endpoint, "GET", null, (data) => {
        const select = $("#occupation-area");
        for (occupation of data) {
            select.append(
                `<option value="${occupation.id}">${occupation.name}</option>`
            );
        }

        select.select2({
            width: null,
        });
    });
}

/**
 *
 */
function _showPcdReportInput() {
    const vacancyType = $("#vacancy-type-id");
    const pcdReportInput = $("#pcd-report-input");
    const pcdReport = $("#pcd-report");
    pcdReportInput.hide();

    vacancyType.on("change", () => {
        const value = vacancyType.val();
        if (value == "2") {
            pcdReportInput.show();
            pcdReport.attr("required", "true");
        } else {
            pcdReportInput.hide();
            pcdReport.removeAttr("required");
        }
    });
}

/**
 *
 */
function _normalizeResumeCompanies() {
    let resumeCompanies = [];
    for (let i = 1; i < _companyCount; i++) {
        const companyStart = $(`#company-${i}-start`).val();
        const companyEnd = $(`#company-${i}-end`).val();

        const resumeCompany = {};
        resumeCompany.companyName = $(`#company-${i}-name`).val();
        resumeCompany.companyActivity = $(`#company-${i}-activity`).val();
        resumeCompany.actualJob = $(`#actual-job-${i}`).is(":checked");
        resumeCompany.companyStart = companyStart
            ? formatDate(companyStart)
            : null;
        resumeCompany.companyEnd = companyEnd ? formatDate(companyEnd) : null;
        resumeCompany.companyLeftReason = $(`#company-${i}-left-reason`).val();

        resumeCompanies.push(resumeCompany);
    }

    return resumeCompanies;
}

/**
 *
 */
function _normalizeResumeLanguages() {
    let resumeLanguagues = [];
    for (let i = 1; i < _languageCount; i++) {
        const language = {};
        language.language = $(`#language-${i}-name`).val();
        language.level = $(`#language-${i}-level`).val();

        resumeLanguagues.push(language);
    }

    return resumeLanguagues;
}

/**
 *
 */
function _complementaryDataForm() {
    let rawData = normalizedFormData("complementary-data");
    delete rawData.languageLevel;
    delete rawData.languageName;

    return rawData;
}

/**
 *
 */
function _listenStateChange() {
    $("#stateId").on("change", (change) =>
        _renderCities(change.target.value, true)
    );
}

/**
 *
 */
function _renderCities(stateId, clearOptions = false, defaultCity = null) {
    const endpoint = url(`states/${stateId}/cities`);
    request(
        endpoint,
        "GET",
        null,
        (cities) => {
            const select = $("#cityId");

            if (clearOptions) {
                select.empty();
            }

            for (city of cities) {
                select.append(
                    `<option value="${city.id}" ${
                        defaultCity == city.name ? "selected" : ""
                    }>${city.name}</option>`
                );
            }
        },
        (err) => console.log(err)
    );
}

/**
 *
 */
function _renderStates(states) {
    _states = states;
    const stateSelect = $("#stateId");
    const rgSelect = $("#rgStateId");

    for (state of states) {
        stateSelect.append(
            `<option value="${state.id}">${state.name}</option>`
        );

        rgSelect.append(`<option value="${state.id}">${state.abbr}</option>`);
    }
}

/**
 *
 */
function _experienceTemplate(id) {
    return `
        <div id="company-${id}">
            <div class="form-group">
                <label for="company-${id}-name">Nome da empresa</label>
                <input id="company-${id}-name" name="companyName" type="text" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label for="company-${id}-activity">Função e atividades</label>
                <textarea id="company-${id}-activity" name="companyActivity" type="text" class="form-control" placeholder=""></textarea>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" name="actualJob" type="checkbox" id="actual-job-${id}" onchange="onActualJobChanged(${id})">
                    <label class="form-check-label" for="actual-job-${id}">
                        Esse é meu atual emprego
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="company-${id}-start">Admitido (nesta parte você coloca a data que INICIOU o seu trabalho, por exemplo: 18/11/21)</label>
                <input id="company-${id}-start" name="companyStart" type="text" class="form-control" placeholder="" data-provide="datepicker">
            </div>
            <div class="form-group">
                <label for="company-${id}-end">Demitido (nesta parte você coloca a data que SAIU o seu trabalho, por exemplo: 18/11/21)</label>
                <input id="company-${id}-end" name="companyEnd" type="text" class="form-control" placeholder="" data-provide="datepicker">
            </div>
            <div class="form-group" id="last-row-company-${id}">
                <label for="company-${id}-left-reason">Motivo da saída</label>
                <input id="company-${id}-left-reason" name="companyLeftReason" type="text" class="form-control" placeholder="">
            </div>
            <hr>
        </div>
    `;
}

/**
 *
 */
function _experienceButtonTemplate(id) {
    return `
    <a class="btn btn-outline-danger" onclick="removeExpirence(${id})">
        <i class="bi bi-trash"></i> Apagar experiência
    </a>
    `;
}

/**
 *
 */
function _languageTemplate(id) {
    return `
    <div id="language-${id}">
        <div class="form-group">
            <label for="language-${id}-name">Idioma</label>
            <input id="language-${id}-name" name="languageName" type="text" class="form-control" placeholder=""></input>
        </div>
        <div class="form-group" id="last-row-language-${id}">
            <label for="language-${id}-level">Nível</label>
            <select id="language-${id}-level" name="languageLevel" class="form-select">
                <option value="1" selected>Básico</option>
                <option value="2">Intermediário</option>
                <option value="3">Avançado</option>
                <option value="4">Fluente</option>
            </select>
        </div>
        <hr>
    </div>
    `;
}

/**
 *
 */
function _languageButtonTemplate(id) {
    return `
    <a class="btn btn-outline-danger" onclick="removeLanguage(${id})">
        <i class="bi bi-trash"></i> Apagar idioma
    </a>
    `;
}
