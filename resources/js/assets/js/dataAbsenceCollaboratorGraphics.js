function setAbsenceCollaboratorData(monthlyAbsences) {
    return {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        // labels: ['Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sep.', 'Oct.', 'Nov.', 'Dic.'],
        datasets: [
            {
                label: 'Días no laborados',
                // backgroundColor: '#ff4600',
                backgroundColor: ['#ff4600', '#ff8600', '#ffb300', '#ffc900', '#d5f300', '#9df300', '#4bf300', '#00f3bf', '#00c5f3', '#007df3', '#4600ff', '#9e00ff'],
                data: Object.values(monthlyAbsences),
                maxBarThickness: 50,
            }
        ]
    };
}

const absenceCollaboratorOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false, // Muestra u oculta la leyenda
            position: 'top', // Posiciones: 'top', 'left', 'bottom', 'right'
            labels: {
                color: '#333', // Color del texto
                font: {
                    size: 12,
                    weight: 'bold',
                },
            },
        },
        tooltip: {
            enabled: true,
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw} días`;
                },
            },
            backgroundColor: '#000',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderWidth: 1,
            borderColor: '#ff4600',
        },
    },
    animation: {
        duration: 1500, // Duración en milisegundos
        easing: 'easeOutBounce', // Tipos: 'easeOutBounce', 'linear', 'easeInOutQuad', etc.
    },
    scales: {
        x: {
            title: {
                display: false,
                text: 'Meses del Año',
                font: {
                    size: 14,
                },
                color: '#555',
            },
            ticks: {
            color: '#333',
            font: {
                size: 12,
            },
            },
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
        y: {
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
    },
};

function setAbsenceTypeData(absencesByType) {
    return {
        labels: ['Enfermedad común', 'Enfermedad laboral', 'Accidente de trabajo', 'Accidente de tránsito', 'Maternidad/Paternidad', 'Cita médica', 'Causa legal', 'Causa extralegal'],
        datasets: [
            {
                label: 'Días no laborados',
                // backgroundColor: '#ff4600',
                backgroundColor: ['#ff4600', '#ff8600', '#ffb300', '#ffc900', '#d5f300', '#9df300', '#4bf300', '#00f3bf', '#00c5f3', '#007df3', '#4600ff', '#9e00ff'],
                data: Object.values(absencesByType),
                maxBarThickness: 50,
            }
        ]
    };
}

const absenceTypeOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false, // Muestra u oculta la leyenda
            position: 'top', // Posiciones: 'top', 'left', 'bottom', 'right'
            labels: {
                color: '#333', // Color del texto
                font: {
                    size: 12,
                    weight: 'bold',
                },
            },
        },
        tooltip: {
            enabled: true,
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw} días`;
                },
            },
            backgroundColor: '#000',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderWidth: 1,
            borderColor: '#ff4600',
        },
    },
    animation: {
        duration: 1500, // Duración en milisegundos
        easing: 'easeOutBounce', // Tipos: 'easeOutBounce', 'linear', 'easeInOutQuad', etc.
    },
    scales: {
        x: {
            title: {
                display: false,
                text: 'Meses del Año',
                font: {
                    size: 14,
                },
                color: '#555',
            },
            ticks: {
            color: '#333',
            font: {
                size: 12,
            },
            },
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
        y: {
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
    },
};

function setAbsenceSubtypeData(absenceType, monthlyAbsencesByClassification) {
    let labels = [];
    let data = [];

    if (
        absenceType === 'Enfermedad común' ||
        absenceType === 'Enfermedad laboral' ||
        absenceType === 'Accidente de trabajo' ||
        absenceType === 'Accidente de tránsito' ||
        absenceType === 'Maternidad/Paternidad'
    ) {
        labels = ['Infecciosas', 'Psicosocial', 'STC', 'De la voz', 'Respiratorio', 'Columna', 'Miembro superior', 'Miembro inferior', 'Hombro', 'Traumatismos', 'Transito', 'Otros'];
        data = [
            monthlyAbsencesByClassification['INFECCIOSAS'] ? monthlyAbsencesByClassification['INFECCIOSAS'] : 0,
            monthlyAbsencesByClassification['PSICOSOCIAL'] ? monthlyAbsencesByClassification['PSICOSOCIAL'] : 0,
            monthlyAbsencesByClassification['STC'] ? monthlyAbsencesByClassification['STC'] : 0,
            monthlyAbsencesByClassification['DE LA VOZ'] ? monthlyAbsencesByClassification['DE LA VOZ'] : 0,
            monthlyAbsencesByClassification['RESPIRATORIO'] ? monthlyAbsencesByClassification['RESPIRATORIO'] : 0,
            monthlyAbsencesByClassification['COLUMNA'] ? monthlyAbsencesByClassification['COLUMNA'] : 0,
            monthlyAbsencesByClassification['MIEMBRO SUPERIOR'] ? monthlyAbsencesByClassification['MIEMBRO SUPERIOR'] : 0,
            monthlyAbsencesByClassification['MIEMBRO INFERIOR'] ? monthlyAbsencesByClassification['MIEMBRO INFERIOR'] : 0,
            monthlyAbsencesByClassification['HOMBRO'] ? monthlyAbsencesByClassification['HOMBRO'] : 0,
            monthlyAbsencesByClassification['TRAUMATISMOS'] ? monthlyAbsencesByClassification['TRAUMATISMOS'] : 0,
            monthlyAbsencesByClassification['TRANSITO'] ? monthlyAbsencesByClassification['TRANSITO'] : 0,
            monthlyAbsencesByClassification['-'] ? monthlyAbsencesByClassification['-'] : 0
        ];
    } else if (absenceType === 'Cita médica') {
        labels = ['Consulta programada NO EPS', 'Consulta programada EPS', 'Consulta odontológica', 'Ayudas diagnósticas', 'Exámenes médicos ARL'];
        data = [
            monthlyAbsencesByClassification['Consulta programada por la empresa en entidad diferente a la EPS'] ? monthlyAbsencesByClassification['Consulta programada por la empresa en entidad diferente a la EPS'] : 0,
            monthlyAbsencesByClassification['Consulta programada por el colaborador en la EPS'] ? monthlyAbsencesByClassification['Consulta programada por el colaborador en la EPS'] : 0,
            monthlyAbsencesByClassification['Consulta odontológica (sea o no programada por la EPS)'] ? monthlyAbsencesByClassification['Consulta odontológica (sea o no programada por la EPS)'] : 0,
            monthlyAbsencesByClassification['Ayudas diagnósticas (sea o no programada por la EPS)'] ? monthlyAbsencesByClassification['Ayudas diagnósticas (sea o no programada por la EPS)'] : 0,
            monthlyAbsencesByClassification['Exámenes médicos en la ARL'] ? monthlyAbsencesByClassification['Exámenes médicos en la ARL'] : 0
        ];
    } else if (absenceType === 'Causa legal') {
        labels = ['Permiso remunerado', 'Permiso no remunerado', 'Suspensión'];
        data = [
            monthlyAbsencesByClassification['Permiso remunerado'] ? monthlyAbsencesByClassification['Permiso remunerado'] : 0,
            monthlyAbsencesByClassification['Permiso no remunerado'] ? monthlyAbsencesByClassification['Permiso no remunerado'] : 0,
            monthlyAbsencesByClassification['Suspensión'] ? monthlyAbsencesByClassification['Suspensión'] : 0
        ];
    } else if (absenceType === 'Causa extralegal') {
        labels = ['Ausencia justificada', 'Ausencia no justificada', 'Calamidad doméstica', 'Permiso por productividad', 'Permiso escolar'];
        data = [
            monthlyAbsencesByClassification['Ausencia justificada'] ? monthlyAbsencesByClassification['Ausencia justificada'] : 0,
            monthlyAbsencesByClassification['Ausencia no justificada'] ? monthlyAbsencesByClassification['Ausencia no justificada'] : 0,
            monthlyAbsencesByClassification['Calamidad doméstica'] ? monthlyAbsencesByClassification['Calamidad doméstica'] : 0,
            monthlyAbsencesByClassification['Permiso por productividad'] ? monthlyAbsencesByClassification['Permiso por productividad'] : 0,
            monthlyAbsencesByClassification['Permiso escolar'] ? monthlyAbsencesByClassification['Permiso escolar'] : 0
        ];
    }

    return {
        labels: labels,
        datasets: [
            {
                label: 'Días no laborados',
                backgroundColor: ['#ff4600', '#ff8600', '#ffb300', '#ffc900', '#d5f300', '#9df300', '#4bf300', '#00f3bf', '#00c5f3', '#007df3', '#4600ff', '#9e00ff'],
                data: data,
                maxBarThickness: 50,
            }
        ]
    };
}

const absenceSubtypeOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false, // Muestra u oculta la leyenda
            position: 'top', // Posiciones: 'top', 'left', 'bottom', 'right'
            labels: {
                color: '#333', // Color del texto
                font: {
                    size: 12,
                    weight: 'bold',
                },
            },
        },
        tooltip: {
            enabled: true,
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw} días`;
                },
            },
            backgroundColor: '#000',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderWidth: 1,
            borderColor: '#ff4600',
        },
    },
    animation: {
        duration: 1500, // Duración en milisegundos
        easing: 'easeOutBounce', // Tipos: 'easeOutBounce', 'linear', 'easeInOutQuad', etc.
    },
    scales: {
        x: {
            title: {
                display: false,
                text: 'Meses del Año',
                font: {
                    size: 14,
                },
                color: '#555',
            },
            ticks: {
            color: '#333',
            font: {
                size: 12,
            },
            },
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
        y: {
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
    },
};

function setAbsenceResponsibleData(absencesByResponsible) {
    return {
        labels: ['Empresa', 'EPS', 'ARL'],
        datasets: [
            {
                label: 'Días no laborados',
                // backgroundColor: '#ff4600',
                backgroundColor: ['#ff4600', '#ff8600', '#ffb300'],
                data: Object.values(absencesByResponsible),
                maxBarThickness: 50,
            }
        ]
    };
}

const absenceResponsibleOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false, // Muestra u oculta la leyenda
            position: 'top', // Posiciones: 'top', 'left', 'bottom', 'right'
            labels: {
                color: '#333', // Color del texto
                font: {
                    size: 12,
                    weight: 'bold',
                },
            },
        },
        tooltip: {
            enabled: true,
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw} días`;
                },
            },
            backgroundColor: '#000',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderWidth: 1,
            borderColor: '#ff4600',
        },
    },
    animation: {
        duration: 1500, // Duración en milisegundos
        easing: 'easeOutBounce', // Tipos: 'easeOutBounce', 'linear', 'easeInOutQuad', etc.
    },
    scales: {
        x: {
            title: {
                display: false,
                text: 'Meses del Año',
                font: {
                    size: 14,
                },
                color: '#555',
            },
            ticks: {
            color: '#333',
            font: {
                size: 12,
            },
            },
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
        y: {
            grid: {
                display: false, // Oculta las líneas del grid
            },
        },
    },
};

export { setAbsenceCollaboratorData, absenceCollaboratorOptions, setAbsenceTypeData, absenceTypeOptions, setAbsenceSubtypeData, absenceSubtypeOptions, setAbsenceResponsibleData , absenceResponsibleOptions };
