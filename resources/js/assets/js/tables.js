function contractsDatatable() {
    if (!$.fn.DataTable.isDataTable("#dt_contracts")) { // Evita reinicialización innecesaria
        $("#dt_contracts").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false, // Se recomienda false si usas responsive
            searching: true,
            ordering: false,
            destroy: true, // Evita errores si la tabla ya está inicializada
            language: {
                zeroRecords: "No se encontraron resultados",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros"
            }
        });
    }
}

function birthdaysDatatable() {
    $(document).ready(() => {
        $("#dt_birthdays").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "ordering": false,
            "language": {
                "zeroRecords": "No se encontraron resultados",
                "search": "Buscar:",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            }
        });
    });
}

function usersDatatable() {
    $(document).ready(() => {
        $("#dt_users").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "ordering": false,
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "language": {
                "zeroRecords": "No se encontraron resultados",
                "search": "Buscar:",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            }
        });
    });
}

function absencesDatatable() {
    let table = $('#dt_absences');

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }

    table.DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        searching: true,
        ordering: false,
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            zeroRecords: "No se encontraron resultados",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros en total)"
        }
    });
}

function disabilitiesDatatable() {
    let table = $('#dt_disabilities');

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }

    table.DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        searching: true,
        ordering: false,
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            zeroRecords: "No se encontraron resultados",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros en total)"
        }
    });
}

// function disabilityDetailDatatable() {
//     let table = $('#dt_disability_detail');

//     if ($.fn.DataTable.isDataTable(table)) {
//         table.DataTable().destroy();
//     }

//     table.DataTable({
//         responsive: true,
//         lengthChange: true,
//         autoWidth: false,
//         searching: true,
//         ordering: false,
//         paging: true,
//         pageLength: 5,
//         lengthMenu: [5, 10, 25, 50, 100],
//         language: {
//             zeroRecords: "No se encontraron resultados",
//             search: "Buscar:",
//             lengthMenu: "Mostrar _MENU_ registros",
//             paginate: {
//                 first: "Primero",
//                 last: "Último",
//                 next: "Siguiente",
//                 previous: "Anterior"
//             },
//             info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//             infoEmpty: "Mostrando 0 a 0 de 0 registros",
//             infoFiltered: "(filtrado de _MAX_ registros en total)"
//         }
//     });
// }

function disabilityDetailDatatable() {
    let table = $('#dt_disability_detail');

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
        table.empty();
    }

    table.DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        searching: true,
        ordering: false,
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            zeroRecords: "No se encontraron resultados",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros en total)"
        }
    });
}

export { contractsDatatable, birthdaysDatatable, usersDatatable, absencesDatatable, disabilitiesDatatable, disabilityDetailDatatable };
