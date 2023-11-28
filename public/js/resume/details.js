var _viaCepInProgress = false;
var _toUpload = {};
var _companyCount = 1;
var _languageCount = 1;
var _userId = null;
var _currentStateId = 0;
var _states = [];

/**
 *
 */
function onInit(user) {
    _userId = user.id;
    _currentStateId = user.state.id;

    _loadMask("cpf", _maskCpf);
    _loadMask("cellphone", _maskCellphone);
    _loadMask("cellphone-2", _maskCellphone);
    _loadMask("cep", _maskCep);

    enableTooltips();

    _hideOtherField("other-sex", $("#sex").val(), 0);
    _hideOtherField("other-civil", $("#civil").val(), 0);
    _hideOtherField("other-volunteer-work", $("#volunteer-work").val(), 1);
    _hideOtherField("other-has-children", $("#has-children").val(), 0);

    _renderOccupations(user.resume.occupations);

    _loadResumeCompanies(user.resume);
    _loadResumeLanguages(user.resume);

    _setDownloadFiles(user);
    $("#save-buttons").hide();
    $("#pcd-report-input").hide();
    $("#add-expirence-button").hide();
    $("#add-language-button").hide();

    if (!user.pcdReport) {
        const pcdReportInput = $("#pcd-report-input");
        pcdReportInput.hide();
    }
}

/**
 *
 */
function edit() {
    $("#edit-shortcut").addClass("disabled");
    maskCellphone("cellphone");
    maskCellphone("cellphone-2");
    maskCep("cep");
    maskCurrency("salary");
    maskCurrency("last-salary");
    datepicker("birth-date");

    _showPcdReportInput();
    _fillAddress();
    _hideOther("sex", "other-sex");
    _hideOther("civil", "other-civil");
    _hideOther("volunteer-work", "other-volunteer-work", 1);
    _hideOther("has-children", "other-has-children");

    $("[disabled]").removeAttr("disabled");
    $("#cpf").attr("disabled", true); // Campo de cpf deve ser SEMPRE somente leitura/disabled
    $("#save-buttons").show();
    $("#edit-buttons").hide();
    $("#add-expirence-button").show();
    $("#add-language-button").show();
    _loadStates();
    _listenStateChange();
    _renderCities(_currentStateId);

    _insertInputs();
    if (_companyCount > 1) {
        _insertDeleteExpirenceButton(_companyCount - 1);
    }

    if (_languageCount > 1) {
        _insertDeleteLanguageButton(_languageCount - 1);
    }
}

/**
 *
 */
function revert(userId) {
    if (!getIsLoading("revert-button")) {
        setIsLoading(true, "revert-button");
        redirect(`${userId}/resume`);
    }
}

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
function addExpirence(company = null, disabled = true) {
    const template = _experienceTemplate(_companyCount, disabled);

    if (_companyCount == 1) {
        $("#company-buttons").prepend(template);
    } else {
        $(template).insertAfter(`#company-${_companyCount - 1}`);
        if (!company) {
            _insertDeleteExpirenceButton(_companyCount);
        }
    }
    datepicker(`company-${_companyCount}-start`);
    datepicker(`company-${_companyCount}-end`);

    if (company) {
        _addExpirenceData(company, _companyCount);
    }

    _companyCount++;
}

/**
 *
 */
function removeExpirence(id) {
    $(`#company-${id}`).remove();
    _companyCount--;
}

/**
 *
 */
function addLanguage() {
    const template = _languageTemplate(_languageCount, false);
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
    $(`#language-${id}`).remove();
    _languageCount--;
}

/**
 *
 */
function save() {
    const allValid = validateAll();

    if (allValid) {
        $("#occupationArea").val(); // Forca valor de select2 existir, se nao, ele fica vazio.
        const personalData = normalizedFormData("signup-personal");
        personalData.birthDate = formatDate(personalData.birthDate);
        personalData.cellphone = normalizeNumber(personalData.cellphone);
        personalData.cellphone2 = normalizeNumber(personalData.cellphone2);
        personalData.cep = normalizeNumber(personalData.cep);
        personalData.rg = normalizeNumber(personalData.rg);

        const historyPersonal = normalizedFormData("signup-history-personal");
        const professionalGoals = normalizedFormData(
            "signup-professional-goals"
        );
        const professionalHistory = normalizedFormData("professional-history");
        const performanceData = _getPerformanceData();

        const complementaryData = _complementaryDataForm();

        const allFormData = {
            ...personalData,
            ...historyPersonal,
            ...professionalGoals,
            ...professionalHistory,
            ...complementaryData,
            ...performanceData,
            resumeCompanies: _normalizeResumeCompanies(),
            resumeLanguagues: _normalizeResumeLanguages(),
            userId: _userId,
        };

        if (!getIsLoading()) {
            setIsLoading(true, "save-button");
            const editEndpoint = url("api/edit");
            request(editEndpoint, "PUT", allFormData, null, _onSignupFail).then(
                (response) => {
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
                }
            );
        }
    }
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
 * @param {string} inputId
 * @param {function} mask
 */
function _loadMask(inputId, mask) {
    const input = $(`#${inputId}`);
    input.val(mask(input.val()));
}

/**
 *
 */
function _onSignupSuccess(response) {
    setIsLoading(false, "save-button");
    sweetAlert(
        "success",
        "Sucesso!",
        "O currículo foi atualizado com sucesso.",
        (r) => redirect(`${response.id}/resume`)
    );
}

/**
 *
 */
function _insertDeleteExpirenceButton(index) {
    const buttomTemplate = _experienceButtonTemplate(index);
    $(`#last-row-company-${index}`).append(buttomTemplate);
}

/**
 *
 */
function _insertDeleteLanguageButton(index) {
    const buttomTemplate = _languageButtonTemplate(index);
    $(`#last-row-language-${index}`).append(buttomTemplate);
}

/**
 *
 */
function _loadResumeCompanies(resume) {
    for (company of resume.companies) {
        addExpirence(company);
    }
}

/**
 *
 */
function _loadResumeLanguages(resume) {
    for (language of resume.languages) {
        if (language && language.language) {
            const template = _languageTemplate(_languageCount, true);

            if (_languageCount == 1) {
                $("#language-buttons").prepend(template);
            } else {
                $(template).insertAfter(`#language-${_languageCount - 1}`);
                if (!language) {
                    _insertDeleteLanguageButton(_languageCount);
                }
            }

            if (language) {
                _addLanguageData(language, _languageCount);
            }

            _languageCount++;
        }
    }
}

function _addLanguageData(language, id) {
    const name = $(`#language-${id}-name`);
    const level = $(`#language-${id}-level`);
    name.val(language.language);
    level.val(language.level);
}

/**
 *
 */
function _addExpirenceData(company, id) {
    const companyName = $(`#company-${id}-name`);
    const companyActivity = $(`#company-${id}-activity`);
    const companyStart = $(`#company-${id}-start`);
    const companyEnd = $(`#company-${id}-end`);
    const companyLeftReason = $(`#company-${id}-left-reason`);
    const actualJob = $(`#actual-job-${id}`);

    if (company.companyName) {
        companyName.val(company.companyName);
    }

    if (company.companyActivity) {
        companyActivity.val(company.companyActivity);
    }

    if (company.companyStart) {
        companyStart.val(company.companyStart);
    }

    if (company.companyEnd) {
        companyEnd.val(company.companyEnd);
    }

    if (company.companyLeftReason) {
        companyLeftReason.val(company.companyLeftReason);
    }

    actualJob.prop("checked", company.actualJob);
}

/**
 *
 */
function _onSignupFail(error) {
    console.log("Signup error >> ", error);

    sweetAlert("error", "Ops!", getErrorMessage(error));
    setIsLoading(false, "save-button");
}

/**
 *
 */
function _insertInputs() {
    $("#recomendation-photo").remove();
    $(
        _inputFileTemplate("recomendation-photo", "recomendationPhoto")
    ).insertAfter("#recomendation-photo-label");

    $("#curriculum-photo").remove();
    $(_inputFileTemplate("curriculum-photo", "curriculumPhoto")).insertAfter(
        "#curriculum-photo-label"
    );

    $("#personal-photo").remove();
    $(_inputFileTemplate("personal-photo", "resumePhoto")).insertAfter(
        "#personal-photo-label"
    );
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
function _setDownloadFiles(user) {
    _setFileDownload(user.photo, "personal-photo");
    _setFileDownload(user.resume.recomendationPhoto, "curriculum-photo");
    _setFileDownload(user.resume.resumePhoto, "recomendation-photo");
    _setFileDownload(user.pcdReport, "pcd-report");
}

/**
 *
 */
function _isImage(filename) {
    if (filename) {
        return !!filename.match(/\.(jpg|jpeg|png|gif|bmp)$/);
    }

    return false;
}

/**
 *
 */
function _setFileDownload(filename, fieldId) {
    const fileFiled = $(`#${fieldId}`);
    const photoUrl = url(`api/asset/${filename}`);

    fileFiled.attr("href", photoUrl);
    if (!_isImage(filename)) {
        fileFiled.attr("download");
    }
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
function _renderOccupations(occupations) {
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

        let selected = occupations.map((occupation) => occupation.id);
        select.val(selected).trigger("change");
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
function _getPerformanceData() {
    return {
        statusId: $("#statusId").val(),
        evaluated: $("#evaluated").val(),
        stamped: $("#stamped").val(),
    };
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
function _loadStates() {
    const endpoint = url("states");
    request(endpoint, "GET", null, _renderStates, (err) => console.log(err));
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
function _experienceTemplate(id, disabled) {
    return `
        <div id="company-${id}">
            <div class="form-group">
                <label for="company-${id}-name">Nome da empresa</label>
                <input id="company-${id}-name" name="companyName" type="text" class="form-control" placeholder="" ${
        disabled ? "disabled" : ""
    }>
            </div>
            <div class="form-group">
                <label for="company-${id}-activity">Função e atividades</label>
                <textarea id="company-${id}-activity" name="companyActivity" type="text" class="form-control" placeholder="" ${
        disabled ? "disabled" : ""
    }></textarea>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" name="actualJob" type="checkbox" id="actual-job-${id}" onchange="onActualJobChanged(${id})" ${
        disabled ? "disabled" : ""
    }>
                    <label class="form-check-label" for="actual-job-${id}">
                        Esse é meu atual emprego
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="company-${id}-start">Admitido (nesta parte você coloca a data que INICIOU o seu trabalho, por exemplo: 18/11/21)</label>
                <input id="company-${id}-start" name="companyStart" type="text" class="form-control" placeholder="" data-provide="datepicker" ${
        disabled ? "disabled" : ""
    }>
            </div>
            <div class="form-group">
                <label for="company-${id}-end">Demitido (nesta parte você coloca a data que SAIU o seu trabalho, por exemplo: 18/11/21)</label>
                <input id="company-${id}-end" name="companyEnd" type="text" class="form-control" placeholder="" data-provide="datepicker" ${
        disabled ? "disabled" : ""
    }>
            </div>
            <div class="form-group" id="last-row-company-${id}">
                <label for="company-${id}-left-reason">Motivo da saída</label>
                <input id="company-${id}-left-reason" name="companyLeftReason" type="text" class="form-control" placeholder="" ${
        disabled ? "disabled" : ""
    }>
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
function _languageTemplate(id, disabled) {
    return `
    <div id="language-${id}">
        <div class="form-group">
            <label for="language-${id}-name">Idioma</label>
            <input id="language-${id}-name" name="languageName" type="text" class="form-control" placeholder="" ${
        disabled ? "disabled" : ""
    }></input>
        </div>
        <div class="form-group" id="last-row-language-${id}">
            <label for="language-${id}-level">Nível</label>
            <select id="language-${id}-level" name="languageLevel" class="form-select" ${
        disabled ? "disabled" : ""
    }>
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

/**
 *
 */
function _inputFileTemplate(inputId, name) {
    return `
        <input id="${inputId}" type="file" class="form-control" onchange="handlePhoto('${name}', this.files)">
    `;
}
