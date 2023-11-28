(function () {
    setTimeout(() => {
        _loadResumesInfos();
        _loadUsersInfos();
        _loadResumeStatus();
    }, 100);
})();

/**
 *
 */
function _loadResumesInfos() {
    const endpoint = url("resumes/infos");
    request(endpoint, "GET", null, _renderResumesCharts, (err) =>
        console.log(err)
    );
}

/**
 *
 */
function _loadUsersInfos() {
    const endpoint = url("users/infos");
    request(endpoint, "GET", null, _renderUsersCharts, (err) =>
        console.log(err)
    );
}

/**
 *
 */
function _loadResumeStatus() {
    const endpoint = url("resumes/status");
    request(endpoint, "GET", null, _renderResumeStatusChart, (err) =>
        console.log(err)
    );
}

/**
 *
 */
function _renderUsersCharts(data) {
    _renderSexChart(data.sex);
    _renderRaceChart(data.races);
    _renderResumeByCitiesChart(data.cities);
}

/**
 *
 */
function _renderResumesCharts(data) {
    _renderOccupationsChart(data.occupationsRaking);
    _renderTypeWorkingChart(data.typeWorking);
    _renderTypeContractChart(data.typeContract);
    _renderVacancyTypesChart(data.vacancyTypes);
}

/**
 *
 */
function _renderResumeStatusChart(results) {
    const statuses = [
        {
            id: 1,
            name: "Não Avaliado",
        },
        {
            id: 2,
            name: "Não qualificado",
        },
        {
            id: 3,
            name: "Qualificado",
        },
        {
            id: 4,
            name: "Contratado",
        },
        {
            id: 5,
            name: "Banco de Dados",
        },
        {
            id: 6,
            name: "Standy By",
        },
        {
            id: 7,
            name: "Alinhamento com a vaga",
        },
        {
            id: 8,
            name: "Espera do contato do contratante",
        },
        {
            id: 9,
            name: "Testes e Questionário",
        },
        {
            id: 10,
            name: "Sem candidatura",
        },
        {
            id: 11,
            name: "Entrevista com o contratante",
        },
        {
            id: 12,
            name: "Entrevista com Recrutador",
        },
    ];

    const labels = [];
    const values = [];

    for (let i = 0; i < statuses.length; i++) {
        let status = statuses[i];

        let result = results.find((r) => r.statusId == i + 1);
        values.push(result ? result.total : 0);
        labels.push(status.name);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                data: values,
                backgroundColor: "#2698d4",
                barThickness: 7,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            indexAxis: "y",
            elements: {
                bar: {
                    borderRadius: 100,
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    };

    new Chart(document.getElementById("resumeStatusChart"), config);
}

/**
 *
 */
function _renderSexChart(sex) {
    const values = Object.values(sex);

    const colors = [];
    const labels = [];
    for (let label of Object.keys(sex)) {
        let color = "";
        let translated = "";
        if (label == "female") {
            color = "#f88ffa";
            translated = "Feminino";
        } else if (label == "male") {
            color = "#2698d4";
            translated = "Masculino";
        } else if (label == "blank") {
            color = "#36ce69";
            translated = "Não definido";
        } else {
            color = "#c9c9c9";
            translated = "Outro";
        }
        labels.push(translated);
        colors.push(color);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                label: "Sexo",
                data: values,
                backgroundColor: colors,
            },
        ],
    };

    const config = {
        type: "pie",
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                },
            },
        },
    };

    new Chart(document.getElementById("sexChart"), config);
}

/**
 *
 */
function _renderRaceChart(races) {
    const labels = [];
    const values = [];

    for (let race of races) {
        labels.push(race.race.name);
        values.push(race.total);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                data: values,
                backgroundColor: "#2698d4",
                barThickness: 7,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            indexAxis: "y",
            elements: {
                bar: {
                    borderRadius: 100,
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    };

    new Chart(document.getElementById("raceChart"), config);
}

/**
 *
 */
function _renderTypeWorkingChart(typeWorking) {
    const labels = ["Integral", "Home Office", "Flexível", "Meio Período"];
    const values = [];

    for (let i = 1; i <= typeWorking.length; i++) {
        let type = typeWorking[i - 1];
        let value = type && type.typeWorking == i ? type.total : 0;
        values.push(value);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                data: values,
                backgroundColor: "#2698d4",
                barThickness: 30,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            indexAxis: "x",
            elements: {
                bar: {
                    borderRadius: 5,
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    };

    new Chart(document.getElementById("typeWorkingChart"), config);
}

/**
 *
 */
function _renderTypeContractChart(contracts) {
    const labels = ["CLT", "PJ", "Freelancer"];
    const values = [];

    for (let i = 1; i <= contracts.length; i++) {
        let contract = contracts[i - 1];
        let value = contract && contract.typeContract == i ? contract.total : 0;
        values.push(value);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                data: values,
                backgroundColor: "#2698d4",
                barThickness: 30,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            indexAxis: "x",
            elements: {
                bar: {
                    borderRadius: 5,
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    };

    new Chart(document.getElementById("typeContractChart"), config);
}

/**
 *
 */
function _renderVacancyTypesChart(vacancyTypes) {
    const labels = [];
    const values = [];

    for (let i = 0; i < vacancyTypes.length; i++) {
        let vacancy = vacancyTypes[i];
        let label = vacancy.vacancy_type.name.split("-");
        labels.push(label[0].trim());
        values.push(vacancy.total);
    }

    const data = {
        labels: labels,
        datasets: [
            {
                data: values,
                backgroundColor: "#2698d4",
                barThickness: 30,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            indexAxis: "x",
            elements: {
                bar: {
                    borderRadius: 5,
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    };

    new Chart(document.getElementById("vacancyTypeChart"), config);
}

/**
 *
 */
function _renderResumeByCitiesChart(results) {
    const table = $("#cities-table");

    for (let i = 0; i < results.length; i++) {
        const result = results[i];
        table.append(`
                <tr>
                    <td class="id">${result.city.name}</td>
                    <td class="right">${result.total}</td>
                </tr>
        `);
    }
}

/**
 *
 */
function _renderOccupationsChart(occupationsRaking) {
    const table = $("#occupations-table");

    for (let i = 0; i < occupationsRaking.length; i++) {
        const occupation = occupationsRaking[i];
        table.append(`
                <tr>
                    <td class="id">${i + 1}</td>
                    <td>${occupation.name}</td>
                </tr>
        `);
    }
}
